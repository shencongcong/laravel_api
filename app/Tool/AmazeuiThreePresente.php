<?php

namespace App\Tool;

class AmazeuiThreePresenter extends \Illuminate\Pagination\BootstrapThreePresenter
{
    public function render()
    {
        if ($this->hasPages()) {
            return sprintf(
                '<ul class="am-pagination am-pagination-centered">%s %s %s</ul>',
                $this->getPreviousButton(),
                $this->getLinks(),
                $this->getNextButton()
            );
        }

        return '';
    }

    /**
     * Get HTML wrapper for disabled text.
     *
     * @param string $text
     *
     * @return string
     */
    protected function getDisabledTextWrapper($text)
    {
        return '<li class="am-disabled"><span>'.$text.'</span></li>';
    }

    /**
     * Get HTML wrapper for active text.
     *
     * @param string $text
     *
     * @return string
     */
    protected function getActivePageWrapper($text)
    {
        return '<li class="am-active"><span>'.$text.'</span></li>';
    }
}