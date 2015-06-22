<?php
/**
 * Created by PhpStorm.
 * User: leonardo
 * Date: 22/06/15
 * Time: 12:51
 */

class TagGenerator {
    /** Random list of words */
    private $_list = ["wretched",
        "datelined",
        "buisson",
        "danava",
        "roxana",
        "archive",
        "febris",
        "expiratory",
        "waff",
        "copperheadism",
        "handiness",
        "tuberculinised",
        "mestor",
        "falconnoid",
        "mucidness",
        "pandemos",
        "nonimputableness",
        "breathable",
        "develope",
        "knurlier",
        "chairmaning",
        "galaxies",
        "subcomplete",
        "hawksbeak",
        "deification",
        "anger",
        "knickknack",
        "posturized",
        "mike",
        "thickly",
        "autotomize"
    ];

    /**
     * Generate a random list of tags
     * @param int $count number of tags to be generated
     * @return string comma separated list of tags
     */
    public function generate($count = 3) {
        shuffle($this->_list);
        return implode(",", array_slice($this->_list, 0, $count));

    }
}