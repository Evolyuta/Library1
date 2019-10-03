<?php

/**
 * @OA\Schema(
 *     description="Some simple request create as example",
 *     type="object",
 *     title="Register storring request",
 * )
 */
class RegisterStoreRequest
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
     *     title="Email",
     *     description="Some text field",
     *     format="string",
     *     example="test5@test.com"
     * )
     *
     * @var string
     */
    public $email;
    /**
     * @OA\Property(
     *     title="Password",
     *     description="Some text field",
     *     format="email",
     *     example="test"
     * )
     *
     * @var string
     */
    public $password;
    /**
     * @OA\Property(
     *     title="Password confirmation",
     *     description="Some text field",
     *     format="string",
     *     example="test"
     * )
     *
     * @var string
     */
    public $password_confirmation;
}
