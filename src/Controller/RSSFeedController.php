<?php

namespace App\Controller;

use App\Entity\TheRegisterCoUkSoftwareHeadlinesFeed;
use FeedIo\Feed\Item;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use FeedIo\FeedIo;

class RSSFeedController extends AbstractController
{
    /**
     * @Route("/", name="rss_feed", methods={"GET"})
     *
     * @param \FeedIo\FeedIo $feedIo
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function rssFeed(FeedIo $feedIo)
    {
        // The feed url that will be read
        $url = 'https://www.theregister.co.uk/software/headlines.atom';

        // Fetch its content
        $feed = $feedIo->read($url)->getFeed();

        // Formatted feed results
        $resultFeed = [];

        // Entire feed text (all entries titles and descriptions joined)
        $feedText = '';
        foreach ($feed as $feedItem) {
            $resultFeed[] = $this->formatFeed($feedItem)->toArray();
            $feedText     .= ' ' . $this->getFeedText($feedItem);
        }

        // Get most frequent words in the feed text, except banned words
        $frequentWords = $this->getFrequentWords($feedText, $this->getBannedWords());

        return $this->render('rss_feed.html.twig', [
            'feed'           => $resultFeed,
            'frequent_words' => $frequentWords,
        ]);
    }

    /**
     * Transforms a feed item to TheRegisterCoUkSoftwareHeadlinesFeed entity
     *
     * @param \FeedIo\Feed\Item $feed
     *
     * @return \App\Entity\TheRegisterCoUkSoftwareHeadlinesFeed
     */
    protected function formatFeed(Item $feed): TheRegisterCoUkSoftwareHeadlinesFeed
    {
        $formattedFeed = new TheRegisterCoUkSoftwareHeadlinesFeed();
        $formattedFeed->setDate($feed->getLastModified());
        $formattedFeed->setAuthorName($feed->getAuthor()->getName());
        $formattedFeed->setAuthorUri($feed->getAuthor()->getUri());
        $formattedFeed->setTitle($feed->getTitle());
        $formattedFeed->setSummary($feed->getDescription());
        $formattedFeed->setLink($feed->getLink());

        return $formattedFeed;
    }

    /**
     * Returns a concatenation of feed title and feed description
     *
     * @param \FeedIo\Feed\Item $feed
     *
     * @return string
     */
    protected function getFeedText(Item $feed): string
    {
        return $feed->getTitle() . ' ' . strip_tags($feed->getDescription());
    }

    /**
     * Get a provided limit of most frequent words in the given text,
     * except banned words
     *
     * @param     $text
     * @param     $bannedWords
     * @param int $limit
     *
     * @return array
     */
    protected function getFrequentWords($text, $bannedWords, $limit = 10)
    {
        // Get words from text
        $words = str_word_count($text, 1);

        // Remove trailing quote(') symbol in the words set
        $words = array_map(
            function($v) {
                return trim($v, "'");
            },
            $words
        );

        // Remove banned words
        $words = array_diff($words, $bannedWords);

        // Count the words
        $wordsCount = $this->arrayCountValuesCaseInsesitive($words);

        // Sort in descending order
        arsort($wordsCount);

        // Return the limited result
        return array_slice($wordsCount, 0, $limit);
    }

    /**
     * Returns an array of banned words
     *
     * @return array
     */
    protected function getBannedWords()
    {
        return [
            'the',
            'be',
            'to',
            'of',
            'and',
            'a',
            'in',
            'that',
            'have',
            'I',
            'it',
            'for',
            'not',
            'on',
            'with',
            'he',
            'as',
            'you',
            'do',
            'at',
            'this',
            'but',
            'his',
            'by',
            'from',
            'they',
            'we',
            'say',
            'her',
            'she',
            'or',
            'an',
            'will',
            'my',
            'one',
            'all',
            'would',
            'there',
            'their',
            'what',
            'so',
            'up',
            'out',
            'if',
            'about',
            'who',
            'get',
            'which',
            'go',
            'me',
        ];
    }

    /**
     * Case-insensitive version of array_count_values()
     *
     * @param array $array
     *
     * @return array
     */
    protected function arrayCountValuesCaseInsesitive(array $array)
    {
        $result = [];
        foreach ($array as $value) {
            foreach ($result as $resultKey => $resultValue) {
                if (strtolower($resultKey) == strtolower($value)) {
                    $result[$resultKey]++;
                    continue 2;
                }
            }
            $result[$value] = 1;
        }

        return $result;
    }
}
