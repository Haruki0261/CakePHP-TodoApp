<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Service\Weather\CurrentWeatherCodeProviderInterface;
use App\Test\Stub\FixedWeatherCodeProvider;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\TodosController Test Case
 *
 * @link \App\Controller\TodosController
 */
class TodosControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->enableCsrfToken();
    }

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Todos',
    ];

    /**
     * Test edit method
     *
     * @return void
     * @link \App\Controller\TodosController::edit()
     */
    public function testEdit(): void
    {
        $this->get('/todos/edit/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Todo編集');
    }

    /**
     * Index lists incomplete count from TodosTable::countIncomplete()
     *
     * @return void
     */
    public function testIndexDisplaysIncompleteCount(): void
    {
        $this->get('/');
        $this->assertResponseOk();
        $this->assertResponseContains('未完了: 2件');
        $this->assertResponseContains('data-incomplete-count="2"');
    }

    /**
     * Index shows motivation copy when a stub weather provider returns clear sky (WMO 0).
     *
     * @return void
     */
    public function testIndexDisplaysWeatherMotivationAdviceWhenClear(): void
    {
        $this->mockService(
            CurrentWeatherCodeProviderInterface::class,
            fn () => new FixedWeatherCodeProvider(0)
        );

        $this->get('/');
        $this->assertResponseOk();
        $this->assertResponseContains('class="weather-motivation-advice"');
        $this->assertResponseContains('今日は晴れなので、外でのタスクも捗りますよ！');
    }

    /**
     * Index shows fallback copy when the provider returns null.
     *
     * @return void
     */
    public function testIndexDisplaysWeatherMotivationFallbackWhenProviderReturnsNull(): void
    {
        $this->mockService(
            CurrentWeatherCodeProviderInterface::class,
            fn () => new FixedWeatherCodeProvider(null)
        );

        $this->get('/');
        $this->assertResponseOk();
        $this->assertResponseContains('今日の天気を取得できませんでした。');
    }

    /**
     * Test update method
     *
     * @return void
     * @link \App\Controller\TodosController::update()
     */
    public function testUpdate(): void
    {
        $data = [
            'title' => 'Updated Todo',
            'content' => 'Updated content',
            'completed' => true
        ];

        $this->post('/todos/update/1', $data);
        $this->assertResponseCode(302);
        $this->assertRedirect('/');
        $this->assertFlashMessage('Todo has been updated.');
    }

    /**
     * Test toggleComplete HTML flow
     *
     * @return void
     */
    public function testToggleCompleteSuccess(): void
    {
        $this->post('/todos/toggle-complete/1');
        $this->assertResponseCode(302);
        $this->assertRedirect('/');
        $this->assertFlashMessage('Todo has been updated.');

        $todos = $this->getTableLocator()->get('Todos');
        $this->assertTrue($todos->get(1)->completed);
    }

    /**
     * @return void
     */
    public function testToggleCompleteNotFound(): void
    {
        $this->post('/todos/toggle-complete/99999');
        $this->assertResponseCode(302);
        $this->assertRedirect('/');
        $this->assertFlashMessage('Todo not found.');
    }

    /**
     * @return void
     */
    public function testToggleCompleteInvalidId(): void
    {
        $this->post('/todos/toggle-complete/abc');
        $this->assertResponseCode(302);
        $this->assertRedirect('/');
        $this->assertFlashMessage('Invalid todo id.');
    }
}
