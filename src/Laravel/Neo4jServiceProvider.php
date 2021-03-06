<?php
/**
 * Neo4jServiceProvider class file
 *
 * @package EndyJasmi\Neo4j\Laravel;
 */
namespace EndyJasmi\Laravel;

use EndyJasmi\Neo4j;
use EndyJasmi\Laravel\Validators\Neo4jValidator;
use Illuminate\Support\ServiceProvider;

/**
 * Neo4jServiceProvider is a concrete implementation of service provider interface
 */
class Neo4jServiceProvider extends ServiceProvider
{
    /**
     * Post register setup
     */
    public function boot()
    {
        $neo4j = $this->app['neo4j'];
        
        $this->app['validator']->resolver(
            function ($translator, $data, $rules, $messages) use ($neo4j) {
                return new Neo4jValidator($translator, $data, $rules, $messages, [], $neo4j);
            }
        );
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->bind('EndyJasmi\Neo4j\ConnectionInterface', 'EndyJasmi\Neo4j\Connection');
        $this->app->bind('EndyJasmi\Neo4j\QueryInterface', 'EndyJasmi\Neo4j\Query');
        $this->app->bind('EndyJasmi\Neo4j\RequestInterface', 'EndyJasmi\Neo4j\Request');
        $this->app->bind('EndyJasmi\Neo4j\Request\StatementInterface', 'EndyJasmi\Neo4j\Request\Statement');
        $this->app->bind('EndyJasmi\Neo4j\ResponseInterface', 'EndyJasmi\Neo4j\Response');
        $this->app->bind('EndyJasmi\Neo4j\Response\ErrorsInterface', 'EndyJasmi\Neo4j\Response\Errors');
        $this->app->bind('EndyJasmi\Neo4j\Response\ResultInterface', 'EndyJasmi\Neo4j\Response\Result');
        $this->app->bind('EndyJasmi\Neo4j\Response\StatusInterface', 'EndyJasmi\Neo4j\Response\Status');

        $this->app->bind('EndyJasmi\Neo4jInterface', 'EndyJasmi\Neo4j');
        $this->app->bind('neo4j', 'EndyJasmi\Neo4j');

        $this->app->bindShared(
            'EndyJasmi\Neo4j',
            function ($app) {
                return new Neo4j(null, $app);
            }
        );
    }
}
