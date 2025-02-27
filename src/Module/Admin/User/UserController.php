<?php

/**
 * Part of starter project.
 *
 * @copyright  Copyright (C) 2021 __ORGANIZATION__.
 * @license    MIT
 */

declare(strict_types=1);

namespace Lyrasoft\Luna\Module\Admin\User;

use Lyrasoft\Luna\Module\Admin\User\Form\EditForm;
use Lyrasoft\Luna\Repository\UserRepository;
use Lyrasoft\Luna\User\ActivationService;
use Unicorn\Controller\CrudController;
use Unicorn\Controller\GridController;
use Unicorn\Upload\FileUploadService;
use Windwalker\Core\Application\AppContext;
use Windwalker\Core\Attributes\Controller;
use Windwalker\Core\Language\TranslatorTrait;
use Windwalker\Core\Router\Navigator;
use Windwalker\Core\Router\RouteUri;
use Windwalker\DI\Attributes\Autowire;
use Windwalker\ORM\Event\AfterSaveEvent;
use Windwalker\Utilities\Symbol;

/**
 * The UserController class.
 */
#[Controller()]
class UserController
{
    use TranslatorTrait;

    public function save(
        AppContext $app,
        CrudController $controller,
        Navigator $nav,
        #[Autowire] UserRepository $repository,
        #[Autowire] EditForm $form,
        FileUploadService $uploadService
    ): mixed {
        $controller->afterSave(
            function (AfterSaveEvent $event) use ($repository, $uploadService, $app) {
                $data = $event->getData();
                $files = $app->file('item');

                unset($data['password']);

                $data['avatar'] = $uploadService->handleFileIfUploaded(
                        $files['avatar'] ?? null,
                        'images/avatar/' . md5((string) $data['id']) . '.jpg'
                    )
                        ?->getUri() ?? $data['avatar'];

                $repository->save($data);
            }
        );

        $uri = $app->call([$controller, 'save'], compact('repository', 'form'));

        switch ($app->input('task')) {
            case 'save2close':
                return $nav->to(UserListView::class);

            case 'save2new':
                return $nav->to(UserEditView::class)->var('new', 1);

            case 'save2copy':
                $controller->rememberForClone($app, $repository);

                return $nav->self($nav::WITHOUT_VARS)->var('new', 1);

            default:
                return $uri;
        }
    }

    public function delete(
        AppContext $app,
        #[Autowire] UserRepository $repository,
        CrudController $controller
    ): mixed {
        return $app->call([$controller, 'delete'], compact('repository'));
    }

    public function filter(
        AppContext $app,
        #[Autowire] UserRepository $repository,
        GridController $controller
    ): mixed {
        return $app->call([$controller, 'filter'], compact('repository'));
    }

    public function batch(
        AppContext $app,
        #[Autowire] UserRepository $repository,
        GridController $controller
    ): mixed {
        if ($app->input('task') === 'resend') {
            return $app->call([$this, 'resend']);
        }

        $data = match ($app->input('task')) {
            'enable' => ['enabled' => 1],
            'disable' => ['enabled' => 0],
            'activate' => ['verified' => 1, 'enabled' => 1, 'activation' => Symbol::empty()],
            default => null
        };

        return $app->call([$controller, 'batch'], compact('repository', 'data'));
    }

    public function resend(AppContext $app, ActivationService $activationService, Navigator $nav): RouteUri
    {
        $ids = (array) $app->input('id');

        foreach ($ids as $id) {
            $activationService->sendActivateMail($id);
        }

        $app->addMessage($this->trans('luna.message.batch.resend.actication.success', count($ids)));

        return $nav->to('user_list');
    }

    public function copy(
        AppContext $app,
        #[Autowire] UserRepository $repository,
        GridController $controller
    ): mixed {
        return $app->call([$controller, 'copy'], compact('repository'));
    }
}
