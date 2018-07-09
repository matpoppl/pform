<?php
/*
 * This file is part of pform.
 *
 * (c) matpoppl
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace pform\Element;

interface ElementInterface
{

    public function getValue();

    public function getErrors();

    public function setErrors(array $errors);

    public function getId();

    public function setId($id);

    public function getName();

    public function setName($name);

    public function addError($msg);

    public function isWritable();

    public function render();
}
