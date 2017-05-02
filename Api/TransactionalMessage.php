<?php

namespace AllProgrammic\Bundle\SendinBlueBundle\Api;


class TransactionalMessage
{
    private $from;

    private $replyTo;

    private $to;

    private $cc;

    private $bcc;

    private $subject;

    private $html;

    private $text;

    private $images;

    private $attachments;

    private $headers;

    public function __construct($subject)
    {
        $this->subject = $subject;
        $this->to = [];
        $this->cc = [];
        $this->bcc = [];
        $this->headers = [
            'Content-Type' => 'text/html; charset=utf-8'
        ];
    }

    public function toArray()
    {
        $data = [
            'from' => $this->from,
            'to' => $this->to,
            'subject' => $this->subject,
            'html' => $this->html,
        ];

        if (!empty($this->replyTo)) {
            $data['replyTo'] = $this->replyTo;
        }

        if (!empty($this->cc)) {
            $data['cc'] = $this->cc;
        }

        if (!empty($this->bcc)) {
            $data['bcc'] = $this->bcc;
        }

        if (!empty($this->headers)) {
            $data['headers'] = $this->headers;
        }

        if (!empty($this->text)) {
            $data['text'] = $this->text;
        }

        if (!empty($this->images)) {
            $data['inline_image'] = $this->images;
        }

        if (!empty($this->attachments)) {
            $data['attachment'] = $this->attachments;
        }

        return $data;
    }

    /**
     * @param $email
     * @param $name
     *
     * @return $this
     */
    public function from($email, $name)
    {
        $this->from = [$email, $name];

        return $this;
    }

    /**
     * @param $email
     * @param string $name
     *
     * @return $this
     */
    public function addTo($email, $name = '')
    {
        $this->to[$email] = $name;

        return $this;
    }

    public function addCc($email, $name = '')
    {
        $this->cc[$email] = $name;

        return $this;
    }

    public function addBcc($email, $name = '')
    {
        $this->bcc[$email] = $name;

        return $this;
    }


    public function replyTo($email, $name)
    {
        $this->replyTo = [$email, $name];

        return $this;
    }

    public function html($content)
    {
        $this->html = $content;

        return $this;
    }

    public function text($content)
    {
        $this->text = $content;

        return $this;
    }

    public function setTag($tag)
    {
        $this->headers['X-Mailin-Tag'] = $tag;
    }
}