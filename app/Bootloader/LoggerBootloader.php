<?php

namespace App\Bootloader;

use Chiron\Http\Response\HtmlResponse;
use Psr\Container\ContainerInterface;
use Chiron\Views\TemplateRendererInterface;
use Chiron\Container\Container;
use Chiron\Bootload\BootloaderInterface;
use Chiron\Container\BindingInterface;
use LogicException;
use SplFileInfo;
use Symfony\Component\Finder\Finder;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\NullHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Processor\PsrLogMessageProcessor;
use Psr\Log\LoggerInterface;
use Chiron\ErrorHandler\ErrorManager;


class LoggerBootloader implements BootloaderInterface
{
    private const NAME = 'CHIRON';
    private const DEFAULT = 'default';

/*
    public function register(KernelInterface $kernel): void
    {
    	$kernel->closure(LoggerInterface::class, function () {
            $logger = new Logger("chiron");
            $formatter = new LineFormatter(
                "[%datetime%] [%level_name%]: %message% %context%\n",
                null,
                true,
                true
            );
            //$formatter = new LineFormatter();

            // Log to timestamped files
            $rotating = new RotatingFileHandler(__DIR__ . '/../../logs/CHIRON.log', 0, Logger::DEBUG);
            $rotating->setFormatter($formatter);
            $logger->pushHandler($rotating);

            return $logger;
        });
    }
*/


    public function register(BindingInterface $container): void
    {
    }

    //https://github.com/spiral/app/blob/master/app/src/Bootloader/LoggingBootloader.php
    //https://github.com/spiral/monolog-bridge/blob/master/src/Bootloader/MonologBootloader.php
    //https://github.com/spiral/monolog-bridge/blob/master/src/LogFactory.php#L70

    public function boot(ErrorManager $manager): void
    {
        $handlerA = new RotatingFileHandler(
            directory('runtime') . 'logs/error.log',
            25,
            Logger::ERROR,
            false,
            null,
            true
        );

        $handlerA->setFormatter(new LineFormatter("[%datetime%] %level_name%: %message% %context%\n"));

        $handlerB = new RotatingFileHandler(
            directory('runtime') . 'logs/debug.log',
            0,
            Logger::DEBUG,
            false,
            null,
            true
        );

        $handlerB->setFormatter(new LineFormatter("[%datetime%] %level_name%: %message% %context%\n"));


        $logger = new Logger(
            self::DEFAULT,
            [$handlerA, $handlerB],
            [new PsrLogMessageProcessor()]
        );

        $manager->setLogger($logger);

    }



    public function register_NEW(BindingInterface $container): void
    {
        $container->add(LoggerInterface::class, function () {


            $handlerA = new RotatingFileHandler(
                directory('runtime') . 'logs/error.log',
                Logger::ERROR,
                25,
                false,
                null,
                true
            );

            $handlerA->setFormatter(new LineFormatter("[%datetime%] %level_name%: %message% %context%\n"));

            $handlerB = new RotatingFileHandler(
                directory('runtime') . 'logs/debug.log',
                Logger::DEBUG,
                0,
                false,
                null,
                true
            );

            $handlerB->setFormatter(new LineFormatter("[%datetime%] %level_name%: %message% %context%\n"));


            $logger = new Logger(
                self::DEFAULT,
                [$handlerA, $handlerB],
                [new PsrLogMessageProcessor()]
            );

            return $logger;
        });
    }









    public function register_OLD(BindingInterface $container): void
    {
        $container->add(LoggerInterface::class, function () {

            $logger = new Logger(self::NAME);

            $handler = new StreamHandler(
                    directory('runtime') . 'logs/error.log',
                    Logger::DEBUG
                );

            $handler->setFormatter(new LineFormatter("[%datetime%] %level_name%: %message% %context%\n"));

            $logger->pushHandler($handler);
            return $logger;
        });
    }

/*
    function logging_extension()
    {
        $ext = '';
        switch ($logging_time = config()->app->logging_time) {
            case 'hourly':
                $ext = date('Y-m-d H-00-00');
            break;
            case 'daily':
                $ext = date('Y-m-d 00-00-00');
            break;
            case 'monthly':
                $ext = date('Y-m-0 00-00-00');
            break;
            case '':
            case null:
            case false:
                return $ext;
            break;
            default:
                throw new Exception('Logging time['.$logging_time.'] not found');
            break;
        }
        return $ext;
    }
    */
}

