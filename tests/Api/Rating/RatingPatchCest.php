<?php

namespace App\Tests\Api\Rating;

use App\Factory\RatingFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class RatingPatchCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'user' => 'string:path',
            'bookmark' => 'string:path',
            'value' => 'integer',
        ];
    }

    public function anonymousUserForbiddenToPatchRating(ApiTester $I): void
    {
        UserFactory::createOne();
        RatingFactory::createOne();

        $I->sendPut('api/ratings/1');
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }

    public function authenticatedUserForbiddenToPatchOtherUserRatings(ApiTester $I): void
    {
        $user = UserFactory::createOne()->object();
        $I->amLoggedInAs($user);

        $author = UserFactory::createOne();
        RatingFactory::createOne(['user' => $author]);

        $I->sendPut('api/ratings/1');
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function authenticatedUserCanPatchOwnData(ApiTester $I): void
    {
        $user = UserFactory::createOne()->object();
        $I->amLoggedInAs($user);

        RatingFactory::createOne(['user' => $user]);

        $I->sendPut('api/ratings/1');
        $I->seeResponseCodeIs(HttpCode::OK);
    }
}
