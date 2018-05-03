<?php

namespace pform\MultiElement;

use PHPUnit\Framework\TestCase;

class SelectTest extends TestCase
{
    public function testSingle()
    {
        $value = 'bb';
        
        $select = new Select('foo', [
            'aa' => 11,
            'bb' => 22,
            'cc' => 33,
        ]);
        
        $select->setValue($value);
        
        $expected = '<select id="foo" name="foo">'
            . '<option value="aa">11</option>'
            . '<option value="bb" selected="">22</option>'
            . '<option value="cc">33</option>'
            . '</select>';

        self::assertEquals($expected, $select->render());
        
        self::assertEquals($value, $select->getValue());
    }
    
    public function testMultiple()
    {
        $value = ['aa', 'cc'];
        
        $select = new Select('foo', [
            'aa' => 11,
            'bb' => 22,
            'cc' => 33,
        ], [
            'multiple' => true,
        ]);
        
        $select->setValue($value);
        
        $expected = '<select id="foo" name="foo" multiple="">'
            . '<option value="aa" selected="">11</option>'
            . '<option value="bb">22</option>'
            . '<option value="cc" selected="">33</option>'
            . '</select>';

        self::assertEquals($expected, $select->render());
        
        self::assertEquals($value, $select->getValue());
    }
}