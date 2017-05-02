<?php

namespace AllProgrammic\Bundle\SendinBlueBundle;


use AllProgrammic\Bundle\SendinBlueBundle\Api\AccountInformation;
use AllProgrammic\Bundle\SendinBlueBundle\Api\FolderInformation;
use AllProgrammic\Bundle\SendinBlueBundle\Api\ListInformation;
use AllProgrammic\Bundle\SendinBlueBundle\Api\Response;
use AllProgrammic\Bundle\SendinBlueBundle\Api\SmtpInformation;
use AllProgrammic\Bundle\SendinBlueBundle\Api\TransactionalMessage;
use AllProgrammic\Bundle\SendinBlueBundle\Api\TransactionalMessageState;
use AllProgrammic\Bundle\SendinBlueBundle\Api\UserInformation;
use Symfony\Component\Serializer\Serializer;

class Client
{
    /** @var Serializer */
    private $serializer;

    /** @var \GuzzleHttp\Client */
    private $guzzleClient;

    private $apiKey;

    public function __construct(Serializer $serializer, $endpoint, $apiKey, $timeout = 10)
    {
        $this->serializer = $serializer;
        $this->guzzleClient = new \GuzzleHttp\Client([
            'base_uri' => $endpoint,
            'timeout' => $timeout,
            'allow_redirects' => true,
            'http_errors' => false,
        ]);

        $this->apiKey = $apiKey;
    }

    /**
     * @return AccountInformation
     */
    public function getAccount()
    {
        $response = $this->doRequest('GET', '/account');

        return AccountInformation::fromResponse($response->data);
    }

    /**
     * @return SmtpInformation
     */
    public function getSmtpDetails()
    {
        $response = $this->doRequest('GET', '/account/smtpdetail');

        return SmtpInformation::fromResponse($response->data);
    }

    public function getFolders($page = 1, $limit = 10, &$errorMessage = null)
    {
        $response = $this->doRequest('GET', '/folder', [
            'page' => $page,
            'page_limit' => $limit
        ]);

        if (!$response->isSuccess()) {
            $errorMessage = $response->message;

            return false;
        }

        return array_map([FolderInformation::class, 'fromResponse'], $response->data);
    }

    public function getLists($page = 1, $limit = 10, $folder = null, &$errorMessage = null)
    {
        $response = $this->doRequest('GET', '/list', array_filter([
            'page' => $page,
            'page_limit' => $limit,
            'list_parent' => $folder,
        ]));

        if (!$response->isSuccess()) {
            $errorMessage = $response->message;

            return false;
        }

        return [
            'page' => $response->data['page'],
            'limit' => $response->data['page_limit'],
            'total' => $response->data['total_list_records'],
            'lists' => array_map([ListInformation::class, 'fromResponse'], $response->data['lists'])
        ];
    }

    public function getList($id, &$errorMessage)
    {
        $response = $this->doRequest('GET', sprintf('/list/%s', $id));

        if (!$response->isSuccess()) {
            $errorMessage = $response->message;

            return false;
        }

        return ListInformation::fromResponse($response->data);
    }

    public function createList($parent, $name, &$errorMessage = null)
    {
        if ($parent instanceof FolderInformation) {
            $parent = $parent->getId();
        }

        $response = $this->doRequest('POST', '/list', [
            'list_parent' => $parent,
            'list_name' => $name,
        ]);

        if (!$response->isSuccess()) {
            $errorMessage = $response->message;

            return false;
        }

        return $response->data['id'];
    }

    public function pushUser(
        $email,
        array $attributes = [],
        $blacklisted = false,
        $linkedList = [],
        $unlinkedList = [],
        $blacklistedSms = false,
        &$errorMessage = null
    ) {
        $response = $this->doRequest('POST', '/user/createdituser', [
            'email' => $email,
            'attributes' => $attributes,
            'blacklisted' => $blacklisted,
            'listid' => $linkedList,
            'listid_unlink' => $unlinkedList,
            'blacklisted_sms' => $blacklistedSms,
        ]);

        if (!$response->isSuccess()) {
            $errorMessage = $response->message;

            return false;
        }

        return $response->data['id'];
    }

    public function getUser($email, &$errorMessage = null)
    {
        $response = $this->doRequest('GET', sprintf('/user/%s', $email));

        if (!$response->isSuccess()) {
            $errorMessage = $response->message;

            return false;
        }

        return UserInformation::fromResponse($response->data);
    }

    public function deleteUser($email, &$errorMessage = null)
    {
        $response = $this->doRequest('DELETE', sprintf('/user/%s', $email));

        if (!$response->isSuccess()) {
            $errorMessage = $response->message;

            return false;
        }

        return true;
    }

    public function sendTransactional(TransactionalMessage $message, &$errorMessage = null)
    {
        $response = $this->doRequest('POST', '/email', $message->toArray());

        if (!$response->isSuccess()) {
            $errorMessage = $response->message;

            return false;
        }

        return $response->data['message-id'];
    }

    public function getTransactionalMessageStatus($messageId)
    {
        $response = $this->doRequest('POST', '/report', [
            'message_id' => $messageId,
        ]);

        return TransactionalMessageState::fromResponse($response->data);
    }

    /**
     * @param $method
     * @param $uri
     * @param array|null $data
     *
     * @return Response
     */
    private function doRequest($method, $uri, array $data = null)
    {
        $requestOptions = [];

        if (!empty($data)) {
            $requestOptions['json'] = $data;
        }

        $requestOptions['headers'] = [
            'api-key' => $this->apiKey
        ];

        $response = $this->guzzleClient->request($method, $uri, $requestOptions);
        $content = $response->getBody()->getContents();

        if (0 === strlen($content)) {
            return new Response('failure', 'No response received');
        }

        return $this->serializer->deserialize($content, Response::class, 'json');
    }
}