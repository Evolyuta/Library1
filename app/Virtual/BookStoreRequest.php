<?php
/**
 * @OA\Schema(
 *     description="Some simple request create as example",
 *     type="object",
 *     title="Book storring request",
 * )
 */
class BookStoreRequest
{
    /**
     * @OA\Property(
     *     title="Title",
     *     description="Some text field",
     *     format="string",
     *     example="test"
     * )
     *
     * @var string
     */
    public $title;
    /**
     * @OA\Property(
     *     title="Publisher",
     *     description="Some text field",
     *     format="string",
     *     example="test"
     * )
     *
     * @var string
     */
    public $publisher;
    /**
     * @OA\Property(
     *     title="Cover",
     *     description="Some text field",
     *     format="enum",
     *     example="soft"
     * )
     *
     * @var string
     */
    public $cover;
    /**
     * @OA\Property(
     *     title="Author Id",
     *     description="Some integer",
     *     format="int64",
     *     example="1"
     * )
     *
     * @var int
     */
    public $author_id;
    /**
     * @OA\Property(
     *     title="Year",
     *     description="Some integer",
     *     format="year",
     *     example="1"
     * )
     *
     * @var int
     */
    public $year;
    /**
     * @OA\Property(
     *     title="Value",
     *     description="Some integer",
     *     format="int64",
     *     example="1"
     * )
     *
     * @var int
     */
    public $pagesAmount;
}
