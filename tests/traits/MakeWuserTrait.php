<?php

use Faker\Factory as Faker;
use App\Models\Wuser;
use App\Repositories\WuserRepository;

trait MakeWuserTrait
{
    /**
     * Create fake instance of Wuser and save it in database
     *
     * @param array $wuserFields
     * @return Wuser
     */
    public function makeWuser($wuserFields = [])
    {
        /** @var WuserRepository $wuserRepo */
        $wuserRepo = App::make(WuserRepository::class);
        $theme = $this->fakeWuserData($wuserFields);
        return $wuserRepo->create($theme);
    }

    /**
     * Get fake instance of Wuser
     *
     * @param array $wuserFields
     * @return Wuser
     */
    public function fakeWuser($wuserFields = [])
    {
        return new Wuser($this->fakeWuserData($wuserFields));
    }

    /**
     * Get fake data of Wuser
     *
     * @param array $postFields
     * @return array
     */
    public function fakeWuserData($wuserFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'username' => $fake->word,
            'password' => $fake->word,
            'interlink' => $fake->word,
            'salt' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $wuserFields);
    }
}
