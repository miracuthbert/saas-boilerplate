<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 2/13/2018
 * Time: 12:18 PM
 */

namespace SAASBoilerplate\App\Traits\Eloquent;


trait NestableCommentsTrait
{
    /**
     * Returns comments nest.
     *
     * @param int $page
     * @param int $perPage
     * @param string $orderDirection
     * @return mixed
     */
    public function nestedComments($page = 1, $perPage = 10, $orderDirection = 'desc')
    {

        $comments = $this->comments();

        if ($comments->count()) {

            //order and group by parent id
            $grouped = $comments->orderBy('created_at', $orderDirection)->get()->groupBy('parent_id');

            //limit comments for each page
            $root = $grouped->get(null)->forPage($page, $perPage);

            //build ids for nesting
            $ids = $this->buildIdNest($root, $grouped);

            $grouped = $comments->whereIn('id', $ids)
                ->with([
                    'user',
                    'parent.user'
                ])->get()->groupBy('parent_id');

            $root = $grouped->get(null);

            return $this->buildNest($root, $grouped);
        }

        return collect();
    }

    /**
     * Builds ids for nesting.
     *
     * @param $root
     * @param $groupedComments
     * @param array $ids
     * @return array
     */
    protected function buildIdNest($root, $groupedComments, &$ids = [])
    {
        foreach ($root as $comment) {
            $ids[] = $comment->id;

            if ($replies = $groupedComments->get($comment->id)) {
                $this->buildIdNest($replies, $groupedComments, $ids);
            }
        }

        return $ids;
    }

    /**
     * Builds comments nest.
     *
     * @param $comments
     * @param $groupedComments
     * @return mixed
     */
    protected function buildNest($comments, $groupedComments)
    {
        return $comments->each(function ($comment) use ($groupedComments) {
            if ($replies = $groupedComments->get($comment->id)) {
                $comment->children = $replies;

                $this->buildNest($comment->children, $groupedComments);
            }
        });
    }
}