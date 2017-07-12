<?php

class MessageTest extends \PHPUnit\Framework\TestCase
{

    protected function setUp()
    {
        parent::setUp();
        $this->message = new Message();
    }

    protected function tearDown()
    {
        $this->message = null;
        parent::tearDown();
    }

    public function testInstanceObject()
    {
        $this->assertTrue($this->message instanceof Message);
    }

    public function testCreateNewMessage()
    {
        $message = new Message();
        $message->setAdminId(1);
        $message->setReceiverId(8);
        $message->setMessageTitle('Witam!');
        $message->setMessageContent('Treść wiadomości');

        $this->assertEquals(1, $message->getAdminId());
        $this->assertEquals(8, $message->getReceiverId());
        $this->assertEquals('Witam!', $message->getMessageTitle());
        $this->assertEquals('Treść wiadomości', $message->getMessageContent());
        $this->assertEquals(0, $message->getMessageStatus());
    }

    public function testId()
    {
        $this->assertEquals($this->message->getId(), -1);
    }

    public function testAdminId()
    {
        $this->assertEquals($this->message->getAdminId(), "");
    }

    public function testReceiverId()
    {
        $this->assertEquals($this->message->getReceiverId(), "");
    }

    public function testMessageTitle()
    {
        $this->assertEquals($this->message->getMessageTitle(), "");
    }

    public function testMessageContent()
    {
        $this->assertEquals($this->message->getMessageContent(), "");
    }

    public function testMessageStatus()
    {
        $this->assertEquals($this->message->getMessagestatus(), 0);
    }
}
