<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 9/6/2019
 * Time: 15:42
 */
namespace lookup\models\entities;

/**
 * Class Image
 * @package lookup\models\entities
 */
class Image {

    /**
     * @var string
     */
    public const TABLE_NAME = "images";

    protected $id = 0;
    protected $site_url = '';       // @TODO This is an UGLY fix!! Shouldn't be underscore, it should be camelcase!
    protected $image_url = '';      // @TODO same as above
    protected $alt = '';
    protected $title = '';
    protected $clicks = 0;
    protected $broken = 0;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getSiteUrl(): string
    {
        return $this->site_url;
    }

    /**
     * @param string $siteUrl
     */
    public function setSiteUrl(string $siteUrl): void
    {
        $this->siteUrl = site_url;
    }

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->image_url;
    }

    /**
     * @param string $imageUrl
     */
    public function setImageUrl(string $imageUrl): void
    {
        $this->image_url = $imageUrl;
    }

    /**
     * @return string
     */
    public function getAlt(): string
    {
        return $this->alt;
    }

    /**
     * @param string $alt
     */
    public function setAlt(string $alt): void
    {
        $this->alt = $alt;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getClicks(): int
    {
        return $this->clicks;
    }

    /**
     * @param int $clicks
     */
    public function setClicks(int $clicks): void
    {
        $this->clicks = $clicks;
    }

    /**
     * @return int
     */
    public function getBroken(): int
    {
        return $this->broken;
    }

    /**
     * @param int $broken
     */
    public function setBroken(int $broken): void
    {
        $this->broken = $broken;
    }
}