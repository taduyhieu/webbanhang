<?php

namespace Fully\Composers;

use Fully\Repositories\Video\VideoInterface;

/**
 * Class VideoComposer.
 *
 * @author
 */
class VideoComposer
{
    /**
     * @var \Fully\Repositories\Video\VideoInterface
     */
    protected $video;

    /**
     * VideoComposer constructor.
     * @param VideoComposer $video
     */
    public function __construct(VideoInterface $video)
    {
        $this->video = $video;
    }

    /**
     * @param $view
     */
    public function compose($view)
    {
        $videos = $this->video->findFirstLimit(3);
        $view->with('videos', $videos);
    }
}
