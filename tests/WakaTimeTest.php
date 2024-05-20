<?php

use Dotenv\Dotenv;
use GuzzleHttp\Client as Guzzle;
use Mabasic\WakaTime\WakaTime;

class WakaTimeTest extends \PHPUnit\Framework\TestCase
{
    protected $wakatime;

    protected $project;

    public function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__."/../");
        $dotenv->load();

        $api_key       = $_ENV['WAKATIME_API_KEY'];
        $this->project = $_ENV['WAKATIME_PROJECT'];

        // Arrange
        $this->wakatime = new WakaTime(new Guzzle, $api_key);
    }

    /** @test */
    public function it_returns_the_number_of_hours_logged_in_today()
    {
        // Act
        $hours = $this->wakatime->getHoursLoggedForToday();

        // Assert
        $this->assertIsInt($hours);
    }

    /** @test */
    public function it_returns_the_number_of_hours_logged_in_today_for_project()
    {
        // Act
        $hours = $this->wakatime->getHoursLoggedForToday($this->project);

        // Assert
        $this->assertIsInt( $hours);
    }

    /** @test */
    public function it_returns_the_number_of_hours_logged_in_yesterday()
    {
        // Act
        $hours = $this->wakatime->getHoursLoggedForYesterday();

        // Assert
        $this->assertIsInt( $hours);
    }

    /** @test */
    public function it_returns_the_number_of_hours_logged_in_yesterday_for_project()
    {
        // Act
        $hours = $this->wakatime->getHoursLoggedForYesterday($this->project);

        // Assert
        $this->assertIsInt( $hours);
    }

    /** @test */
    public function it_returns_the_number_of_hours_logged_in_last_7_days()
    {
        // Act
        $hours = $this->wakatime->getHoursLoggedForLast7Days();

        // Assert
        $this->assertIsInt( $hours);
    }

    /** @test */
    public function it_returns_the_number_of_hours_logged_in_last_7_days_for_project()
    {
        // Act
        $hours = $this->wakatime->getHoursLoggedForLast7Days($this->project);

        // Assert
        $this->assertIsInt($hours);
    }

    /** @test */
    public function it_returns_the_number_of_hours_logged_in_last_30_days()
    {
        // Act
        $hours = $this->wakatime->getHoursLoggedForLast30Days();

        // Assert
        $this->assertIsInt( $hours);
    }

    /** @test */
    public function it_returns_the_number_of_hours_logged_in_last_30_days_for_project()
    {
        // Act
        $hours = $this->wakatime->getHoursLoggedForLast30Days($this->project);

        // Assert
        $this->assertIsInt( $hours);
    }

    /** @test */
    public function it_returns_the_number_of_hours_logged_in_this_month()
    {
        // Act
        $hours = $this->wakatime->getHoursLoggedForThisMonth();

        // Assert
        $this->assertIsInt( $hours);
    }

    /** @test */
    public function it_returns_the_number_of_hours_logged_in_this_month_for_project()
    {
        // Act
        $hours = $this->wakatime->getHoursLoggedForThisMonth($this->project);

        // Assert
        $this->assertIsInt( $hours);
    }

    /** @test */
    public function it_returns_the_number_of_hours_logged_in_last_month()
    {
        // Act
        $hours = $this->wakatime->getHoursLoggedForLastMonth();

        // Assert
        $this->assertIsInt( $hours);
    }

    /** @test */
    public function it_returns_the_number_of_hours_logged_in_last_month_for_project()
    {
        // Act
        $hours = $this->wakatime->getHoursLoggedForLastMonth($this->project);

        // Assert
        $this->assertIsInt( $hours);
    }

    /**
     * Users
     */

    /** @test */
    public function it_returns_the_currently_logged_in_user()
    {
        $response = $this->wakatime->currentUser();

        $this->assertIsArray( $response);
    }

    /** @test */
    public function it_returns_info_for_user()
    {
        $response = $this->wakatime->users('mabasic');

        $this->assertIsArray( $response);
    }

    /**
     * Stats
     */

    /** @test */
    public function it_returns_user_stats_for_range()
    {
        // Act
        $range    = 'last_30_days';
        $response = $this->wakatime->stats($range, $this->project);

        // Assert
        $this->assertIsArray( $response);
    }

    /** @test */
    public function it_returns_user_stats_for_range_and_project()
    {
        // Act
        $range    = 'last_30_days';
        $response = $this->wakatime->stats($range, $this->project);

        // Assert
        $this->assertIsArray( $response);
    }

    /**
     * Summaries
     */

    /** @test */
    public function it_returns_summaries_for_period()
    {
        $startDate = '11/21/2014';
        $endDate   = '12/21/2014';

        $response = $this->wakatime->summaries($startDate, $endDate);

        $this->assertIsArray( $response);
    }

    /** @test */
    public function it_returns_summaries_for_period_and_project()
    {
        $startDate = '12/19/2014';
        $endDate   = '12/20/2014';
        $project   = $this->project;

        $response = $this->wakatime->summaries($startDate, $endDate, $project);

        $this->assertIsArray( $response);
    }

    /**
     * Heartbeats
     */

    /** @test */
    public function it_returns_heartbeats_for_given_day()
    {
        $date = '01/22/2016';
        $show = 'time,entity,type,project,language,branch,is_write,is_debugging';

        $response = $this->wakatime->heartbeats($date, $show);

        $this->assertIsArray( $response);
    }

    /**
     * Durations
     */

    /** @test */
    public function it_returns_durations_for_given_day()
    {
        $date     = '01/22/2016';
        $project  = $this->project;
        $branches = null;

        $response = $this->wakatime->durations($date, $project, $branches);

        $this->assertIsArray( $response);
    }
}
