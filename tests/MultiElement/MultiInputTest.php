<?php

namespace pform\MultiElement;

use PHPUnit\Framework\TestCase;

class MultiElementTest extends TestCase
{
    public function testMultiple()
    {
        $input = new MultiInput('checkbox', 'foo', array());
        self::assertTrue($input->isMultiple());

        $input = new MultiInput('radio', 'foo', array());
        self::assertFalse($input->isMultiple());

        $input = new MultiInput('radio', 'foo', array(), array(
            'multiple' => true,
        ));        
        self::assertTrue($input->isMultiple());
        
        $input = new MultiInput('checkbox', 'foo', array(), array(
            'multiple' => false,
        ));
        self::assertFalse($input->isMultiple());
    }
    
    public function testCheckboxValue()
    {
        $expected = array('bb' => 'bb', 'cc' => 'cc');
        
        $input = new MultiInput('checkbox', 'foo', [
            'aa' => 11,
            'bb' => 22,
            'cc' => 33,
        ]);
        
        $input->setValue($expected);
        
        self::assertEquals($expected, $input->getValue());
    }
    
    public function testRadioValue()
    {
        $expected = 'bb';
        
        $input = new MultiInput('radio', 'foo', [
            'aa' => 11,
            'bb' => 22,
            'cc' => 33,
        ]);
        
        $input->setValue($expected);
        
        self::assertEquals($expected, $input->getValue());
    }
    
    public function testRadioChecked()
    {
        $input = new MultiInput('radio', 'foo', [
            'aa' => 11,
            'bb' => 22,
            'cc' => 33,
        ]);
        
        $input->setValue('bb');
        
        $expected = '<label for="foo-aa"><input type="radio" name="foo" value="aa" id="foo-aa" />11</label><br />'
            . '<label for="foo-bb"><input type="radio" name="foo" value="bb" id="foo-bb" checked="" />22</label><br />'
            . '<label for="foo-cc"><input type="radio" name="foo" value="cc" id="foo-cc" />33</label><br />';

        self::assertEquals($expected, $input->render());
    }
    
    public function testCheckboxChecked()
    {
        $input = new MultiInput('checkbox', 'foo', [
            'aa' => 11,
            'bb' => 22,
            'cc' => 33,
        ]);
        
        $input->setValue(array('bb' => 'bb', 'cc' => 'cc'));
        
        $expected = '<label for="foo-aa"><input type="checkbox" name="foo[aa]" value="aa" id="foo-aa" />11</label><br />'
            . '<label for="foo-bb"><input type="checkbox" name="foo[bb]" value="bb" id="foo-bb" checked="" />22</label><br />'
            . '<label for="foo-cc"><input type="checkbox" name="foo[cc]" value="cc" id="foo-cc" checked="" />33</label><br />';

        self::assertEquals($expected, $input->render());
    }
}