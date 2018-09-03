<?php

namespace Fully\Composers;
use Fully\Repositories\Video\VideoInterface;

/**
 * Class MenuComposer.
 *
 * @author
 */
class ReportingComposer {

    /**
     * @var \Fully\Repositories\Video\VideoInterface
     */
    protected $video;

    /**
     * VideoComposer constructor.
     * @param VideoInterface $video
     */
    public function __construct(VideoInterface $video) {
        $this->video = $video;
    }

    /**
     * @param $view
     */
    public function compose($view) {
        $reporting = $this->video->getReporting();
        $view->with('reporting', $reporting);
    }

}
