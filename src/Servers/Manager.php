<?php

namespace Rsyncr\Servers;

use Rsyncr\Servers\Exceptions\NotFoundException;
use Rsyncr\Storage\Manager as StorageManager;

class Manager
{
    /**
     * @var StorageManager Storage handling.
     */
    protected $storageManager;

    /**
     * @var array List of store server connections.
     */
    protected $servers = [];

    /**
     * Manager constructor.
     */
    public function __construct()
    {
        // created a new Manager instance.
        $this->storageManager = new StorageManager();

        // Load servers from storage.
        $this->loadServers();
    }

    /**
     * Load the stored servers.
     */
    protected function loadServers()
    {
        // Get the servers configuration array from the servers.yml file.
        $servers = $this->storageManager->getConfiguration('servers');

        // Register each server configuration as a Server instance.
        foreach ($servers as $serverData) {
            $this->registerServer($serverData);
        }
    }

    /**
     * Register a configuration array as a server instance.
     *
     * @param array $data Server connection information.
     */
    public function registerServer(array $data)
    {
        // Generate a new server connection instance.
        $server = new Server($data);

        // Register the server connection into the servers list.
        $this->servers[$server->alias] = $server;
    }

    /**
     * Create a server connection instance with the provided configuration
     * data and write the configuration server with the updated information.
     *
     * @param array $data Server connection information.
     */
    public function createServer(array $data)
    {
        // Register a new server connection instance.
        $this->registerServer($data);

        // Write the configuration server with the updated information
        $this->writeServers();
    }

    /**
     * Deletes a server connection from instance and storage.
     *
     * @param string $alias Alias of the server connection to be deleted.
     */
    public function deleteServer($alias)
    {
        // Find the server.
        $server = $this->getServer($alias);

        // Forget the server from the server connection instances list
        unset($this->servers[$server->alias]);

        // Write the updated configuration file
        $this->writeServers();
    }

    /**
     * Write the current server instances into a servers.yml storage file.
     */
    protected function writeServers()
    {
        $servers = [];
        // Parse all current instances into the array representation.
        foreach ($this->servers as $server) {
            $servers[] = $server->toArray();
        }

        // Write the servers array into the servers.yml file.
        $this->storageManager->writeConfiguration($servers, 'servers');
    }

    /**
     * Get a server instance.
     *
     * @param string $alias Server connection alias.
     *
     * @return Server The Server connection instance.
     *
     * @throws NotFoundException When the desired alias is not registered.
     */
    public function getServer($alias)
    {
        if ($this->serverExists($alias)) {
            return $this->servers[$alias];
        } else {
            throw new NotFoundException('Server not found.');
        }
    }

    /**
     * Get all the server connection instances.
     *
     * @return array A array containing all the server connection instances.
     */
    public function getServers()
    {
        return $this->servers;
    }

    /**
     * Is a given connection alias registered?
     *
     * @param string $alias The given server connection instance alias.
     *
     * @return bool Registered or not.
     */
    public function serverExists($alias)
    {
        return array_key_exists($alias, $this->servers);
    }
}