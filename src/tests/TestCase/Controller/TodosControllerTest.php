<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

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
