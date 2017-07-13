<?php

class ItemTest extends \PHPUnit\Framework\TestCase
{

    protected function setUp()
    {
        parent::setUp();
        $this->item = new Item();
    }

    protected function tearDown()
    {
        $this->item = null;
        parent::tearDown();
    }

    public function testInstanceObject()
    {
        $this->assertTrue($this->item instanceof Item);
    }

    public function testCreateNewItem()
    {
        $item = new Item();
        $item->setName('Huawei P8 Lite');
        $item->setPrice(1599);
        $item->setDescription('Bardzo korzystna cena');
        $item->setAvailability(15);
        $item->setGroup(11);

        $this->assertEquals("Huawei P8 Lite", $item->getName());
        $this->assertEquals(1599, $item->getPrice());
        $this->assertEquals('Bardzo korzystna cena', $item->getDescription());
        $this->assertEquals(15, $item->getAvailability());
        $this->assertEquals(11, $item->getGroup());
    }

    public function testId()
    {
        $this->assertEquals($this->item->getId(), -1);
    }

    public function testName()
    {
        $this->assertEquals($this->item->getName(), "");
    }

    public function testPrice()
    {
        $this->assertNull($this->item->getPrice(), null);
    }

    public function testDescription()
    {
        $this->assertEquals($this->item->getDescription(), "");
    }

    public function testAvailability()
    {
        $this->assertNull($this->item->getAvailability(), null);
    }

    public function testGroupId()
    {
        $this->assertNull($this->item->getGroup(), null);
    }
}
