<?php namespace Zilla\Config;

class TestStore implements StoreInterface {

    public function load($key)
    {
        return ['foo' =>
            ['bar' => 'baz']
        ];
    }

}

class ConfigServiceTest extends \PHPUnit_Framework_TestCase {

    public function testCanGetConfig()
    {
        $config = new ConfigService(['foo' => 'bar']);

        $result = $config->get('foo');

        $this->assertEquals('bar', $result);
    }

    public function testReturnsNullIfNotFounf()
    {
        $config = new ConfigService();

        $result = $config->get('foo');

        $this->assertNull($result);
    }

    public function testCheckIfConfigIsLoaded()
    {
        $config = new ConfigService(['foo' => 'bar']);

        $result = $config->has('foo');

        $this->assertTrue($result);

        $result = $config->has('bar');

        $this->assertFalse($result);
    }

    public function testCanSetADefaultValueWhenGetting()
    {
        $config = new ConfigService();

        $result = $config->get('foo', 'default');

        $this->assertEquals('default', $result);
    }

    public function testCanSetConfig()
    {
        $config = new ConfigService();

        $config->set('foo', 'bar');
        $result = $config->get('foo');

        $this->assertEquals('bar', $result);
    }

    public function testStoreIsOfStoreInterface()
    {
        $config = new ConfigService();

        $result = $config->getStore();

        $this->assertInstanceOf('Zilla\Config\StoreInterface', $result);
    }

    public function testSetsNullStoreByDefault()
    {
        $config = new ConfigService;

        $result = $config->getStore();

        $this->assertInstanceOf('Zilla\Config\NullStore', $result);
    }

    public function testGetViaDotNotation()
    {
        $config = new ConfigService([
            'foo' => [
                'bar' => 'baz'
            ]
        ]);

        $result = $config->get('foo.bar');

        $this->assertEquals('baz', $result);
    }


    public function testCanCheckViaDotNotatio()
    {
        $config = new ConfigService([
            'foo' => [
                'bar' => 'baz'
            ]
        ]);

        $result = $config->has('foo.bar');

        $this->assertTrue($result);

        $result = $config->has('not.available');

        $this->assertFalse($result);

    }

    public function testCanSetViaDotNotation()
    {
        $config = new ConfigService();

        $config->set('foo.bar', 'baz');

        $this->assertEquals('baz', $config->get('foo.bar'));
    }

    public function testCanGetFromStore()
    {
        $config = new ConfigService([], new TestStore);

        $result = $config->get('foo.bar');

        $this->assertEquals('baz', $result);
    }


}
