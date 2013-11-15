<?php

class RecommendController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	*/

	public function recommend($repoName)
	{
		list($selectedRepo, $allRepos) = Repo::getAllWithSelectedByName($repoName);

		// Get matrix of stars for selected repo
		$selectedRepoMatrix = Star::generateMatrixByRepoId($selectedRepo->id);
		// Calculate magnitude for selected repo
		$selectedRepoMagnitude = $this->magnitude($selectedRepoMatrix);

		$similarityIndex = [];
		foreach($allRepos as $repoKey => $repo)
		{
			// Get matrix of stars for other repo
			$repoMatrix = Star::generateMatrixByRepoId($repo->id);
			// Calculate magnitude for other repo
			$repoMagnitude = $this->magnitude($repoMatrix);

			$similarityIndex[$repo->id] = $this->similarity($selectedRepoMatrix, $repoMatrix, $selectedRepoMagnitude, $repoMagnitude);
		}

		// Sort high to low
		arsort($similarityIndex);
		// Gets repo ids of top 5 recommendations
		$similarityIndex = array_keys(array_slice($similarityIndex, 0, 5, true));

		// Filter allRepos to get top 5 repos
		$top5 = $allRepos->filter(function($repo) use ($similarityIndex)
		{
			if (array_search($repo->id, $similarityIndex) !== false)
				return $repo;
		});

		return $top5->toJson();
	}

	/**
	 * Calculates dot product of two given matrices
	 * @param  array $aMatrix First matrix
	 * @param  array $bMatrix Second matrix
	 * @return int            Dot product of matrices
	 */
	private function dotProduct($aMatrix, $bMatrix)
	{
		$arr = [];
		foreach($aMatrix as $key => $value)
		{
			$arr[$key] =  $value * $bMatrix[$key];
		}
		return array_sum($arr);
	}

	/**
	 * Calculates magnitude of given matrix
	 * @param  array $matrix Matrix
	 * @return float         Magnitude of matrix
	 */
	private function magnitude($matrix)
	{
		array_map(function($value) {
			$value = $value * $value;
		}, $matrix);

		return sqrt(array_sum($matrix));
	}

	/**
	 * Calculates cosine similarity for two given matrices
	 * @param  array $aMatrix    First matrix
	 * @param  array $bMatrix    Second matrix
	 * @param  float $aMagnitude (Optional) Calculated magnitude of first matrix
	 * @param  float $bMagnitude (Optional) Calculated magnitude of second matrix
	 * @return float             Cosine similarity of matrices
	 */
	private function similarity($aMatrix, $bMatrix, $aMagnitude = null, $bMagnitude = null)
	{
		// If magnitudes not passed in, calculate
		if ( ! $aMagnitude) $this->magnitude($aMatrix);
		if ( ! $bMagnitude) $this->magnitude($bMatrix);

		// Calculate dot product for selected repo and other repo
		$dotProduct = $this->dotProduct($aMatrix, $bMatrix);

		// Calculate product of selected repo magnitude and other repo magnitude
		$magnitudeProduct = $aMagnitude * $bMagnitude;

		// Calculate similarity
		return $dotProduct / $magnitudeProduct;
	}

}