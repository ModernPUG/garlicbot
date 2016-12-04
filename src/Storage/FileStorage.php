<?php
namespace ModernPUG\GarlicBot\Storage;

use ModernPUG\GarlicBot\Contracts\ActionInterface;
use ModernPUG\GarlicBot\Contracts\StorageInterface;
use ModernPUG\GarlicBot\Contracts\TokenizerInterface;
use ModernPUG\GarlicBot\Math\JaccardSimilarity;
use ModernPUG\GarlicBot\Math\MinHashCalculator;
use Psr\Log\LoggerInterface;

class FileStorage implements StorageInterface
{
    /** @var float */
    protected $threshold = 0.332;
    
    /** @var string */
    protected $fileName = '.garlicbot.learn.php';
    
    /** @var \ModernPUG\GarlicBot\Contracts\TokenizerInterface */
    protected $tokenizer;
    
    /** @var \ModernPUG\GarlicBot\Math\MinHashCalculator */
    protected $minHashCalc;
    
    /** @var \ModernPUG\GarlicBot\Math\JaccardSimilarity */
    protected $similarity;
    
    /** @var array */
    protected $models = [];
    
    /** @var \Psr\Log\LoggerInterface */
    protected $logger;
    
    public function __construct(
        TokenizerInterface $tokenizer,
        MinHashCalculator $minHashCalc,
        JaccardSimilarity $similarity,
        LoggerInterface $logger = null
    ) {
        $this->tokenizer = $tokenizer;
        $this->minHashCalc = $minHashCalc;
        $this->similarity = $similarity;
        if (file_exists($this->fileName)) {
            $this->models = require $this->fileName;
        }
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function store(ActionInterface $action)
    {
        $indexOfCommands = [];

        foreach ($action->hears() as $command) {
            $tokens = $this->tokenizer->tokenize($command);
            $indexOfCommands[] = $this->minHashCalc->calculate($tokens);
        }
        $this->models[$action->getIdentifier()] = $indexOfCommands;
        file_put_contents($this->fileName, '<?php return ' . var_export($this->models, true) . ';');
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ActionInterface $action)
    {
        unset($this->models[$action->getIdentifier()]);
        file_put_contents($this->fileName, '<?php return ' . var_export($this->models, true) . ';');
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        if (file_exists($this->fileName)) {
            unlink($this->fileName);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function search(string $keyword)
    {
        $tokens = $this->tokenizer->tokenize($keyword);
        $hashes = $this->minHashCalc->calculate($tokens);

        if ($this->logger) {
            $this->logger->debug("input tokens : [" . implode(', ', $tokens) . "]");
            $this->logger->debug("input hashes : [" . implode(', ', $hashes) . "]");
        }

        $candidates = $this->getActionCandidates($this->models, $hashes);

        if ($this->logger) {
            foreach ($candidates as $candidate) {
                $this->logger->debug(sprintf("%0.3f%% ", $candidate['similarity'] * 100) . $candidate['action']);
            }
        }

        if (count($candidates)) {
            return $candidates[0]['action'];
        }
        return null;
    }

    protected function getActionCandidates(array $models, array $hashes = [])
    {
        $candidates = [];
        foreach ($models as $action => $indexes) {
            foreach ($indexes as $index) {
                $similarity = $this->similarity->similarity($index, $hashes);
                if ($similarity > $this->threshold) {
                    $candidates[] = [
                        'similarity' => $similarity,
                        'action' => $action,
                    ];
                }
            }
        }
        usort($candidates, function ($current, $next) {
            if ($current['similarity'] < $next['similarity']) {
                return 1;
            }
            return $current['similarity'] > $next['similarity'] ? -1 : 0;
        });
        return $candidates;
    }
}
