<?php

class UserTest extends \PHPUnit\Framework\TestCase
{

    protected function setUp()
    {
        parent::setUp();
        $this->user = new User();
    }

    protected function tearDown()
    {
        $this->user = null;
        parent::tearDown();
    }

    public function testInstanceObject()
    {
        $this->assertTrue($this->user instanceof User);
    }

    public function testRegister()
    {
        $user = new User();
        $user->setName('Jacek');
        $user->setSurname('kulka');
        $user->setPassword('qwerty');
        $user->setEmail('jacek82@onet.pl');
        $user->setAddress('Schwarzwald');

        $this->assertEquals('Jacek', $user->getName());
        $this->assertEquals('kulka', $user->getSurname());
        $this->assertEquals('qwerty', $user->getPassword());
        $this->assertEquals('jacek82@onet.pl', $user->getEmail());
        $this->assertEquals('Schwarzwald', $user->getAddress());
    }

    public function testId()
    {
        $this->assertEquals($this->user->getId(), -1);
    }

    public function testName()
    {
        $this->assertEquals($this->user->getName(), "");
    }

    public function testSurname()
    {
        $this->assertEquals($this->user->getSurname(), "");
    }

    public function testEmail()
    {
        $this->assertEquals($this->user->getEmail(), "");
    }

    public function testPassword()
    {
        $this->assertEquals($this->user->getPassword(), "");
    }

    public function testAddress()
    {
        $this->assertEquals($this->user->getAddress(), "");
    }
}
