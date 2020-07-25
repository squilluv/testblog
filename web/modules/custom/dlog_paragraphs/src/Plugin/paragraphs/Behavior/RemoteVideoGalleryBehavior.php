<?php

namespace Drupal\dlog_paragraphs\Plugin\paragraphs\Behavior;

use Drupal\Component\Utility\Html;
use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\paragraphs\Entity\ParagraphsType;
use Drupal\paragraphs\ParagraphInterface;
use Drupal\paragraphs\ParagraphsBehaviorBase;

/**
 * @ParagraphsBehavior(
 *  id = "dlog_paragraphs_remote_video_gallery",
 *  label = @Translation("Remote video gallery settings"),
 *  description = @Translation("Settings for remote video gallery paragraph type"),
 *  weight = 0,
 * )
 */
class RemoteVideoGalleryBehavior extends ParagraphsBehaviorBase
{
    public static function isApplicable(ParagraphsType $paragraphs_type)
    {
        return $paragraphs_type->id() == "gallery_remote_video";
    }

    public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode)
    {
        $videos_per_row = $paragraph->getBehaviorSetting($this->getPluginId(), 'items_per_row', 4);
        $bem_block = 'paragraph-' . $paragraph->bundle() . ($view_mode == 'default' ? '' : '-' . $view_mode) . '--video-per-row-' . $videos_per_row;
        $build['#attributes']['class'][] = Html::getClass($bem_block);
    }

    public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state)
    {
        $form['items_per_row'] = [
            '#type' => 'select',
            '#title' => $this->t('Number og images per row'),
            '#options' => [
                '2' => $this->formatPlural(2, '1 video per row', '@count videos per row'),
                '3' => $this->formatPlural(3, '1 video per row', '@count videos per row'),
                '4' => $this->formatPlural(4, '1 video per row', '@count videos per row'),
            ],
            '#default_value' => $paragraph->getBehaviorSetting($this->getPluginId(), 'items_per_row', 4),
        ];

        return $form;
    }

    public function settingsSummary(Paragraph $paragraph)
    {
    }
}
