<?php

/**
 * Part of starter project.
 *
 * @copyright  Copyright (C) 2021 __ORGANIZATION__.
 * @license    MIT
 */

declare(strict_types=1);

namespace Lyrasoft\Luna\Module\Admin\Article;

use Lyrasoft\Luna\Module\Admin\Article\Form\GridForm;
use Lyrasoft\Luna\Repository\ArticleRepository;
use Windwalker\Core\Application\AppContext;
use Windwalker\Core\Attributes\ViewModel;
use Windwalker\Core\Form\FormFactory;
use Windwalker\Core\Language\TranslatorTrait;
use Windwalker\Core\View\View;
use Windwalker\Core\View\ViewModelInterface;
use Windwalker\Data\Collection;
use Windwalker\DI\Attributes\Autowire;
use Windwalker\ORM\ORM;

/**
 * The ContentListView class.
 */
#[ViewModel(
    layout: [
        'default' => 'article-list',
        'modal' => 'article-modal',
    ],
    js: 'article-list.js'
)]
class ArticleListView implements ViewModelInterface
{
    use TranslatorTrait;

    public function __construct(
        protected ORM $orm,
        #[Autowire]
        protected ArticleRepository $repository,
        protected FormFactory $formFactory
    ) {
    }

    /**
     * Prepare view data.
     *
     * @param  AppContext  $app   The request app context.
     * @param  View        $view  The view object.
     *
     * @return  array
     */
    public function prepare(AppContext $app, View $view): array
    {
        $type = $app->input('type');

        $state = $this->repository->getState();

        $this->repository->setType($type);

        // Prepare Items
        $page     = $state->rememberFromRequest('page');
        $limit    = $state->rememberFromRequest('limit');
        $filter   = (array) $state->rememberFromRequest('filter');
        $search   = (array) $state->rememberFromRequest('search');
        $ordering = $state->rememberFromRequest('list_ordering') ?? $this->getDefaultOrdering();

        $items = $this->repository->getListSelector()
            ->setFilters($filter)
            ->searchTextFor(
                $search['*'] ?? '',
                $this->getSearchFields()
            )
            ->ordering($ordering)
            ->page($page)
            ->limit($limit);

        $pagination = $items->getPagination();

        // Prepare Form
        $form = $this->formFactory->create(GridForm::class);
        $form->fill(compact('search', 'filter'));

        $showFilters = $this->showFilterBar($filter);

        // Browser Title
        $view->setTitle($this->trans('luna.article.list.title',));

        return compact('items', 'pagination', 'form', 'showFilters', 'ordering', 'type');
    }

    public function prepareItem(Collection $item): object
    {
        return $this->repository->getEntityMapper()->toEntity($item);
    }

    /**
     * Get default ordering.
     *
     * @return  string
     */
    public function getDefaultOrdering(): string
    {
        return 'article.category_id, article.id DESC';
    }

    /**
     * Get search fields.
     *
     * @return  string[]
     */
    public function getSearchFields(): array
    {
        return [
            'article.id',
            'article.title',
            'article.alias',
            'article.introtext',
            'article.fulltext',
        ];
    }

    /**
     * Is reorder enabled.
     *
     * @param  string  $ordering
     *
     * @return  bool
     */
    public function reorderEnabled(string $ordering): bool
    {
        return $ordering === 'article.category_id, article.ordering ASC';
    }

    /**
     * Can show Filter bar
     *
     * @param  array  $filter
     *
     * @return  bool
     */
    public function showFilterBar(array $filter): bool
    {
        foreach ($filter as $value) {
            if ($value !== null && (string) $value !== '') {
                return true;
            }
        }

        return false;
    }
}
