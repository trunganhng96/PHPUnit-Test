<?php
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase {
    protected $article;

    protected function setUp(): void {
        $this->article = new App\Article;
    }
    public function testTitleIsEmptyByDeafault() {
        $this->assertEmpty($this->article->title);
    }

    public function testSlugIsEmptyWithNoTitle() {
        $this->assertSame($this->article->getSlug(), "");
    }

    // public function testSlugHasSpaceReplaceByUnderscores() {
    //     $this->article->title = "An example article";
    //     $this->assertEquals($this->article->getSlug(), "An_example_article");
    // }

    // public function testSlugHasWhiteSpaceReplaceBySingleUnderscore() {
    //     $this->article->title = "An   example   \n   article";
    //     $this->assertEquals($this->article->getSlug(), "An_example_article");
    // }    

    // public function testSlugDoesNotStartOrEndWithAnUnderscore() {
    //     $this->article->title = " An example article";
    //     $this->assertEquals($this->article->getSlug(), "An_example_article");
    // }

    // public function testSlugDoesNotHaveAnyNonWordCharacters() {
    //     $this->article->title = "Read! This! Now!";
    //     $this->assertEquals($this->article->getSlug(), "Read_This_Now");
    // }

    public function titleProvider() {
        return [
            'Slug Has Space Replace By Underscores' => ["An example article", "An_example_article"],
            'Slug Has White Space Replace By Single Underscore' => ["An   example   \n   article", "An_example_article"],
            'Slug Does Not Start Or End With An Underscore' => [" An example article", "An_example_article"],
            'Slug Does Not Have Any Non Word Characters' => ["Read! This! Now!", "Read_This_Now"]
        ];
     }
    
    /**
     * @dataProvider titleProvider
     */
    public function testSlug($title, $slug) {
        $this->article->title = $title;
        $this->assertEquals($this->article->getSlug(), $slug);
    }
}
?>