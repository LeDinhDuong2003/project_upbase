<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\User;

final readonly class UserQuery
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver
        return User::find($args['id']);
    }
    // public function userById($root, array $args, $context, $info)
    // {
    //     // Kiểm tra nếu người dùng với id được yêu cầu có tồn tại trong cơ sở dữ liệu
    //     return User::find($args['id']);
    // }
}
