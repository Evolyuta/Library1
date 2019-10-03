<?php

/**
 * @OA\Schema(
 *     description="Some simple request create as example",
 *     type="object",
 *     title="Author storring request",
 * )
 */
class AuthorStoreRequest
{
    /**
     * @OA\Property(
     *     title="Name",
     *     description="Some text field",
     *     format="string",
     *     example="test"
     * )
     *
     * @var string
     */
    public $name;
    /**
     * @OA\Property(
     *     title="Surname",
     *     description="Some text field",
     *     format="string",
     *     example="test"
     * )
     *
     * @var string
     */
    public $surname;
    /**
     * @OA\Property(
     *     title="Middlename",
     *     description="Some text field",
     *     format="string",
     *     example="test"
     * )
     *
     * @var string
     */
    public $middlename;
    /**
     * @OA\Property(
     *     title="Country",
     *     description="Some text field",
     *     format="string",
     *     example="test"
     * )
     *
     * @var string
     */
    public $country;
}
