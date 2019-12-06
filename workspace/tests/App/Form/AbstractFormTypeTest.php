<?php

namespace Tests\App\Form;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Test\TypeTestCase;

abstract class AbstractFormTypeTest extends TypeTestCase
{
    protected function formTestData(string $formClass, array $formData, $expectedData): void
    {
        $form = $this->factory->create($formClass);

        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($expectedData, $form->getData());
        $this->formViewTest($form, $formData);
    }

    protected function formViewTest(FormInterface $form, array $formData): void
    {
        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
