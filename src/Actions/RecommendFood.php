<?php
namespace ModernPUG\GarlicBot\Actions;

use ModernPUG\GarlicBot\ActionAbstract;

class RecommendFood extends ActionAbstract
{
    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return "뭐 먹을지 물어보세요.";
    }

    /**
     * {@inheritdoc}
     */
    public function hears(): array
    {
        return [
            '마늘아 밥 뭐먹을까?',
            '마늘씨 밥 뭐먹지?',
            '마늘아 뭐먹을까',
            '마늘아 배고파',
            '마늘아 맛난거',
            '마늘아 맛나는거',
            '마늘아 먹을거 뭐가 있지',
            '마늘아 먹을거 추천',
            '마늘 맛집 추천',
            '마늘 아무거나 맛있는거좀 추천',
            '마늘 맛난거 이야기해줘',
            '마늘아 점심 뭐먹어',
            '마늘아 저녁 뭐먹지',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function response(): string
    {
        $foods = ['피자', '햄버거', '맥도날드', '기름진거', '매콤한거',
            '고기고기한것', '인도식카레', '달달한거', '돈가스', '스파게티', '베트남쌀국수',
            '수제버거', '타코타코', '연어', '라멘', '덮밥', '샐러드', '깔끔한거', '안매운거',
        ];
        return $foods[array_rand($foods)] . " 어떠신가요?";
    }
}
