<?php declare(strict_types=1);

namespace NickolayShuliak\ShopwarePlugin\Subscriber;

use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Event\ThemeCompilerEnrichScssVariablesEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BuyBtnSubscriber implements EventSubscriberInterface
{
    protected SystemConfigService $systemConfig;

    // add the `SystemConfigService` to your constructor
    public function __construct(SystemConfigService $systemConfig)
    {
        $this->systemConfig = $systemConfig;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ThemeCompilerEnrichScssVariablesEvent::class => 'onAddVariables'
        ];
    }

    public function onAddVariables(ThemeCompilerEnrichScssVariablesEvent $event): void
    {
        /** @var string $configExampleField */
        $configPluginHeaderBgColor = $this->systemConfig->get('NickolayShuliakShopwarePlugin.config.sassPluginHeaderBgColor', $event->getSalesChannelId());

        if ($configPluginHeaderBgColor) {
            // pass the value from `configPluginHeaderBgColor` to `addVariable`
            $event->addVariable('sass-plugin-header-bg-color', $configPluginHeaderBgColor);
        }
    }
}