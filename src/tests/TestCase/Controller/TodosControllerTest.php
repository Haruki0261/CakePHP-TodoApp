<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\TodosController;
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
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Todos',
    ];

    /**
     * Test index method
     *
     * @return void
     * @link \App\Controller\TodosController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @link \App\Controller\TodosController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @link \App\Controller\TodosController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

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

        $this->patch('/todos/update/1', $data);
        $this->assertResponseCode(302);
        $this->assertRedirect('/todos');
        $this->assertFlashMessage('Todo has been updated.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @link \App\Controller\TodosController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
