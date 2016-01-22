<?php namespace Mabasic\WakaTime\Traits;

trait Reports {

    /**
     * Calculates hours logged for a specific period.
     * You can optionally specify a project.
     *
     * @param $startDate
     * @param $endDate
     * @param null $project
     * @return int
     */
    public function getHoursLoggedFor($startDate, $endDate, $project = null)
    {
        $response = $this->summaries($endDate, $startDate, $project);

        return $this->calculateHoursLogged($response);
    }

    /**
     * Calculates hours logged in last xy days, months ...
     * You can optionally specify a project.
     *
     * @param $period
     * @param null $project
     * @return int
     */
    public function getHoursLoggedForLast($period, $project = null)
    {
        $todayDate = date('m/d/Y');
        $endDate   = date_format(date_sub(date_create($todayDate), date_interval_create_from_date_string($period)), 'm/d/Y');

        return $this->getHoursLoggedFor($todayDate, $endDate, $project);
    }

    /**
     * Returns hours logged today.
     * You can optionally specify a project.
     *
     * @param null $project
     * @return int
     */
    public function getHoursLoggedForToday($project = null)
    {
        return $this->getHoursLoggedForLast('0 days', $project);
    }

    /**
     * Returns hours logged yesterday.
     * You can optionally specify a project.
     *
     * @param null $project
     * @return int
     */
    public function getHoursLoggedForYesterday($project = null)
    {
        return $this->getHoursLoggedForLast('1 day', $project);
    }

    /**
     * Basic users can only see data for maximum 7 days.
     * Become a Premium user to preserve all data history.
     *
     * _You can still use any method as long as it is under 7 days._
     *
     * @param null $project
     * @return int
     */
    public function getHoursLoggedForLast7Days($project = null)
    {
        return $this->getHoursLoggedForLast('7 days', $project);
    }

    /**
     * Calculates hours logged for last 30 days in history.
     * You can optionally specify a project.
     *
     * @param null $project
     * @return int
     */
    public function getHoursLoggedForLast30Days($project = null)
    {
        return $this->getHoursLoggedForLast('1 month', $project);
    }

    /**
     * Calculates hours logged for this month.
     * You can optionally specify a project.
     *
     * @param null $project
     * @return int
     */
    public function getHoursLoggedForThisMonth($project = null)
    {
        $endDate   = date('m/01/Y');
        $startDate = date('m/d/Y');

        return $this->getHoursLoggedFor($startDate, $endDate, $project);
    }

    /**
     * Calculates hours logged for last month.
     * You can optionally specify a project.
     *
     * @param null $project
     * @return int
     */
    public function getHoursLoggedForLastMonth($project = null)
    {
        $endDate   = date_format(date_sub(date_create(), date_interval_create_from_date_string('1 month')), 'm/01/Y');
        $startDate = date_format(date_sub(date_create(), date_interval_create_from_date_string('1 month')), 'm/t/Y');

        return $this->getHoursLoggedFor($startDate, $endDate, $project);
    }

    /**
     * Loops through response and sums seconds to calculate hours logged.
     * Converts seconds to hours.
     *
     * @param $response
     * @return int
     */
    protected function calculateHoursLogged($response)
    {
        $totalSeconds = 0;

        foreach ($response['data'] as $day) {
            $totalSeconds += $day['grand_total']['total_seconds'];
        }

        return (int) floor($totalSeconds / 3600);
    }

}