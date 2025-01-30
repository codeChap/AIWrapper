<?php

declare(strict_types=1);

namespace Codechap\Aiwrapper;

use Codechap\Aiwrapper\Interfaces\AI\AIServiceInterface;
use Codechap\Aiwrapper\Services\AnthropicService;
use Codechap\Aiwrapper\Services\ExampleService;
use Codechap\Aiwrapper\Services\GroqService;
use Codechap\Aiwrapper\Services\MistralService;
use Codechap\Aiwrapper\Services\OpenAiService;
use Codechap\Aiwrapper\Services\XaiService;

class AIWrapper {
    private AIServiceInterface $service;
    private static $serviceRegistry = [];

    public function __construct(
        private readonly string $serviceType,
        private readonly string $apiKey,
    ) {
        if (empty(trim($serviceType))) {
            throw new \InvalidArgumentException("Service name cannot be empty");
        }

        if (empty(trim($apiKey))) {
            throw new \InvalidArgumentException("API key cannot be empty");
        }

        $this->loadServices();

        if (!isset(self::$serviceRegistry[$serviceType])) {
            // Try to load the service directly from the Services directory
            $serviceClass = 'Codechap\\Aiwrapper\\Services\\' . ucfirst($serviceType) . 'Service';
            if (class_exists($serviceClass)) {
                self::registerService($serviceType, $serviceClass);
            } else {
                throw new \InvalidArgumentException("Service {$serviceType} not found");
            }
        }

        $serviceClass = self::$serviceRegistry[$serviceType];
        $this->service = new $serviceClass($apiKey);
    }

    /**
     * Load all services from the Services directory
     */
    private function loadServices(): void {
        if (empty(self::$serviceRegistry)) {
            $servicesPath = __DIR__ . '/Services';
            if (is_dir($servicesPath)) {
                foreach (glob($servicesPath . '/*Service.php') as $file) {
                    $filename = basename($file, '.php');
                    $serviceType = strtolower(str_replace('Service', '', $filename));
                    $serviceClass = 'Codechap\\Aiwrapper\\Services\\' . $filename;
                    self::registerService($serviceType, $serviceClass);
                }
            }
        }
    }

    /**
     * Register a new AI service
     */
    public static function registerService(string $serviceType, string $serviceClass): void {
        self::$serviceRegistry[$serviceType] = $serviceClass;
    }

    /**
     * Query the AI service
     *
     * @param string|array $prompt The prompt to send to the AI service
     * @return AIServiceInterface The service instance for method chaining
     */
    public function query(string|array $prompt): AIServiceInterface {
        return $this->service->query($prompt);
    }

    /**
     * Gets the content of the result.
     *
     * @return string The content of the result
     */
    public function content(): string
    {
        return $this->service->content();
    }

    /**
     * Get a specific property from the service
     *
     * @param string $name The property name to get
     * @return mixed The value of the property
     */
    public function get(string $name)
    {
        return $this->service->get($name);
    }

    /**
     * Set a specific property for the service
     *
     * @param string $name The property name to set
     * @param mixed $value The value to set
     * @return self Returns the current instance
     */
    public function set(string $name, $value): self
    {
        $this->service->set($name, $value);
        return $this;
    }
}
