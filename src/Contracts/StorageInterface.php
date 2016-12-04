<?php
namespace ModernPUG\GarlicBot\Contracts;

interface StorageInterface
{
    /**
     * @param \ModernPUG\GarlicBot\Contracts\ActionInterface $action
     * @return void
     */
    public function store(ActionInterface $action);

    /**
     * @return void
     */
    public function clear();
    
    /**
     * @param string $keyword
     * @return string
     */
    public function search(string $keyword);

    /**
     * @param \ModernPUG\GarlicBot\Contracts\ActionInterface $action
     * @return void
     */
    public function delete(ActionInterface $action);
}
