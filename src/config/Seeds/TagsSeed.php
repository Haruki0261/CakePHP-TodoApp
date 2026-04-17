<?php
declare(strict_types=1);

use Migrations\BaseSeed;

/**
 * Tags seed.
 */
class TagsSeed extends BaseSeed
{
    /**
     * Run Method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/migrations/4/en/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $now = date('Y-m-d H:i:s');
        $data = [];
        for ($i = 1; $i <= 20; $i++) {
            $ratio = ($i - 1) / 19;
            $r = (int)round(220 * (1 - $ratio) + 50 * $ratio);
            $g = (int)round(40 + 80 * $ratio);
            $b = (int)round(60 + 195 * $ratio);
            $data[] = [
                'name' => '優先' . $i,
                'color' => sprintf('#%02x%02x%02x', $r, $g, $b),
                'created' => $now,
                'modified' => $now,
            ];
        }

        $table = $this->table('tags');
        $table->insert($data)->save();
    }
}
