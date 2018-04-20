<?php
namespace Port1HybridAuth\Subscriber;

use Doctrine\Common\Collections\ArrayCollection;
use Shopware\Components\Theme\LessDefinition;

class PluginAssetsCompilerSubscriber extends AbstractSubscriber
{
    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            'Theme_Compiler_Collect_Plugin_Less' => 'onCollectLessFiles'
        ];
    }

    /**
     * @param \Enlight_Event_EventArgs $args
     *
     * @return ArrayCollection
     */
    public function onCollectLessFiles (\Enlight_Event_EventArgs $args)
    {
        $lessDef = new LessDefinition(
            [],
            [
                sprintf(
                    '%1$s%2$sResources%2$sviews%2$sfrontend%2$s_public%2$ssrc%2$sless%2$shybrid_auth.less',
                    $this->getPath(),
                    \DIRECTORY_SEPARATOR
                )
            ],
            $this->getPath()
        );

        return new ArrayCollection([$lessDef]);
    }
}
