<?php

/**
 * Part of starter project.
 *
 * @copyright  Copyright (C) 2021 __ORGANIZATION__.
 * @license    MIT
 */

declare(strict_types=1);

namespace Lyrasoft\Luna\Module\Admin\User\Form;

use Lyrasoft\Luna\Enum\UserEnabled;
use Lyrasoft\Luna\Enum\UserVerified;
use Unicorn\Enum\BasicState;
use Windwalker\Core\Language\TranslatorTrait;
use Windwalker\Form\Field\ListField;
use Windwalker\Form\Field\SearchField;
use Windwalker\Form\FieldDefinitionInterface;
use Windwalker\Form\Form;

/**
 * The GridForm class.
 */
class GridForm implements FieldDefinitionInterface
{
    use TranslatorTrait;

    /**
     * Define the form fields.
     *
     * @param  Form  $form  The Windwalker form object.
     *
     * @return  void
     */
    public function define(Form $form): void
    {
        $form->ns(
            'search',
            function (Form $form) {
                $form->add('*', SearchField::class)
                    ->placeholder($this->trans('unicorn.grid.search.label'))
                    ->attr('x-on:keydown.enter', '$store.grid.sendFilter($event)');
            }
        );

        $form->ns(
            'filter',
            function (Form $form) {
                $form->add('user.enabled', ListField::class)
                    ->label($this->trans('luna.user.field.enabled'))
                    ->option($this->trans('unicorn.select.placeholder'), '')
                    ->registerOptions(UserEnabled::getTransItems($this->lang))
                    ->attr('x-on:change', '$store.grid.sendFilter()');

                $form->add('user.verified', ListField::class)
                    ->label($this->trans('luna.user.field.verified'))
                    ->option($this->trans('unicorn.select.placeholder'), '')
                    ->registerOptions(UserVerified::getTransItems($this->lang))
                    ->attr('x-on:change', '$store.grid.sendFilter()');
            }
        );

        $form->ns(
            'batch',
            function (Form $form) {
                $form->add('state', ListField::class)
                    ->label('State')
                    ->option('- No change -', '')
                    ->option('Published', (string) BasicState::PUBLISHED()->getValue())
                    ->option('Unpublished', (string) BasicState::UNPUBLISHED()->getValue());
            }
        );
    }
}
