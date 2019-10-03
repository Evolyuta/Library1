<?php

/**
 * @OA\Schema(
 *     description="Some simple request create as example",
 *     type="object",
 *     title="Login storring request",
 * )
 */
class LoginStoreRequest
{
    /**
     * @OA\Property(
     *     title="Email",
     *     description="Some text field",
     *     format="email",
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
     *     format="string",
     *     example="test"
     * )
     *
     * @var string
     */
    public $password;
}
