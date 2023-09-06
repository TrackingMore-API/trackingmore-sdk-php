<?php

namespace TrackingMore\Interfaces;

interface TrackingsInterface
{

    /**
     * Create a tracking.
     * @param array $params
     * @return mixed
     */
    public function createTracking($params = []);

    /**
     * Get tracking results of multiple trackings.
     * @param array $params
     * @return mixed
     */
    public function getTrackingResults($params = []);

    /**
     * Create multiple trackings (Max. 40 tracking numbers create in one call).
     * @param array $params
     * @return mixed
     */
    public function batchCreateTrackings($params = []);

    /**
     * Update a tracking by ID.
     * @param string $idString
     * @param array $params
     * @return mixed
     */
    public function updateTrackingByID($idString= '', $params = []);

    /**
     * Delete a tracking by ID.
     * @param string $idString
     * @return mixed
     */
    public function deleteTrackingByID($idString = '');

    /**
     * Retrack expired tracking by ID.
     * @param string $idString
     * @return mixed
     */
    public function retrackTrackingByID($idString = '');

}