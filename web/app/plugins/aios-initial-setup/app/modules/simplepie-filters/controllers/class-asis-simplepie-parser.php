<?php

namespace AiosInitialSetup\App\Modules\SimplePieFilter\Controllers;

use SimplePie_Parser;

class Parser extends SimplePie_Parser
{

	public function fetch_banned_keywords()
  {
    $cdnUrl = cdnDomainSwitcher();
		$keyword_arrs = get_transient('aios-initial-setup-simplepie-filters');

		if ( $keyword_arrs ) {
      $request  = wp_remote_get( "$cdnUrl/plugins/aios-initial-setup/simplepie-keywords.json", [
        'timeout' => 10
      ]);
      $response = wp_remote_retrieve_body( $request );
			set_transient( 'aios-initial-setup-simplepie-filters', $response, DAY_IN_SECONDS );
		}

		$keywords = json_decode($keyword_arrs);
		$keywords = $keywords->keywords;

		return $keywords;

	}

	public function is_title_flagged($item)
  {

		$banned_keywords = $this->fetch_banned_keywords();

		foreach ( $banned_keywords as $keyword) {
			if (isset( $item['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['title'][0]['data'])) {
				if (stripos($item['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['title'][0]['data'], $keyword) !== false) {
					return true;
				}
			} else if (isset( $item['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['title'][0]['data'])) {
				if (stripos($item['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['title'][0]['data'], $keyword) !== false) {
					return true;
				}
			} else if (isset( $item['child'][SIMPLEPIE_NAMESPACE_RSS_10]['title'][0]['data'])) {
				if (stripos($item['child'][SIMPLEPIE_NAMESPACE_RSS_10]['title'][0]['data'], $keyword) !== false) {
					return true;
				}
			} else if (isset( $item['child'][SIMPLEPIE_NAMESPACE_RSS_090]['title'][0]['data'])) {
				if (stripos($item['child'][SIMPLEPIE_NAMESPACE_RSS_090]['title'][0]['data'], $keyword) !== false) {
					return true;
				}
			} else if (isset( $item['child'][SIMPLEPIE_NAMESPACE_RSS_20]['title'][0]['data'])) {
				if (stripos($item['child'][SIMPLEPIE_NAMESPACE_RSS_20]['title'][0]['data'], $keyword) !== false) {
					return true;
				}
			} else if (isset( $item['child'][SIMPLEPIE_NAMESPACE_DC_11]['title'][0]['data'])) {
				if (stripos($item['child'][SIMPLEPIE_NAMESPACE_DC_11]['title'][0]['data'], $keyword) !== false) {
					return true;
				}
			} else if (isset( $item['child'][SIMPLEPIE_NAMESPACE_DC_10]['title'][0]['data'])) {
				if (stripos($item['child'][SIMPLEPIE_NAMESPACE_DC_10]['title'][0]['data'], $keyword) !== false) {
					return true;
				}
			}
		}

		return false;
	}

	public function is_content_flagged($item)
  {
		$banned_keywords = $this->fetch_banned_keywords();

		foreach ( $banned_keywords as $keyword) {

			if (isset( $item['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['summary'][0]['data'])) {
				if (stripos($item['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['summary'][0]['data'], $keyword) !== false) {
					return true;
				}
			} else if (isset( $item['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['summary'][0]['data'])) {
				if (stripos($item['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['summary'][0]['data'], $keyword) !== false) {
					return true;
				}
			} else if (isset( $item['child'][SIMPLEPIE_NAMESPACE_RSS_10]['description'][0]['data'])) {
				if (stripos($item['child'][SIMPLEPIE_NAMESPACE_RSS_10]['description'][0]['data'], $keyword) !== false) {
					return true;
				}
			} else if (isset( $item['child'][SIMPLEPIE_NAMESPACE_RSS_20]['description'][0]['data'])) {
				if (stripos($item['child'][SIMPLEPIE_NAMESPACE_RSS_20]['description'][0]['data'], $keyword) !== false) {
					return true;
				}
			} else if (isset( $item['child'][SIMPLEPIE_NAMESPACE_DC_11]['description'][0]['data'])) {
				if (stripos($item['child'][SIMPLEPIE_NAMESPACE_DC_11]['description'][0]['data'], $keyword) !== false) {
					return true;
				}
			} else if (isset( $item['child'][SIMPLEPIE_NAMESPACE_DC_10]['description'][0]['data'])) {
				if (stripos($item['child'][SIMPLEPIE_NAMESPACE_DC_10]['description'][0]['data'], $keyword) !== false) {
					return true;
				}
			} else if (isset( $item['child'][SIMPLEPIE_NAMESPACE_ITUNES]['summary'][0]['data'])) {
				if (stripos($item['child'][SIMPLEPIE_NAMESPACE_ITUNES]['summary'][0]['data'], $keyword) !== false) {
					return true;
				}
			} else if (isset( $item['child'][SIMPLEPIE_NAMESPACE_ITUNES]['subtitle'][0]['data'])) {
				if (stripos($item['child'][SIMPLEPIE_NAMESPACE_ITUNES]['subtitle'][0]['data'], $keyword) !== false) {
					return true;
				}
			} else if (isset( $item['child'][SIMPLEPIE_NAMESPACE_RSS_090]['description'][0]['data'])) {
				if (stripos($item['child'][SIMPLEPIE_NAMESPACE_RSS_090]['description'][0]['data'], $keyword) !== false) {
					return true;
				}
			}
		}

		return false;
	}

	public function remove_banned_items($items)
  {
		// Look for banned keywords in selected tags
		foreach( $items as $key => $item ) {
			if ( $this->is_title_flagged( $item)) {
				unset( $items[$key] );
			}

			if ( $this->is_content_flagged( $item)) {
				unset( $items[$key] );
			}
		}
	}

	public function filter_data()
  {
		if (isset( $this->data['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['feed'][0]['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['entry'])) {
			$this->remove_banned_items( $this->data['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['feed'][0]['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['entry'] );
		}

		if (isset( $this->data['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['feed'][0]['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['entry'])) {
			$this->remove_banned_items( $this->data['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['feed'][0]['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['entry'] );
		}

		if (isset( $this->data['child'][SIMPLEPIE_NAMESPACE_RDF]['RDF'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_10]['item'])) {
			$this->remove_banned_items( $this->data['child'][SIMPLEPIE_NAMESPACE_RDF]['RDF'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_10]['item'] );
		}

		if (isset( $this->data['child'][SIMPLEPIE_NAMESPACE_RDF]['RDF'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_090]['item'])) {
			$this->remove_banned_items( $this->data['child'][SIMPLEPIE_NAMESPACE_RDF]['RDF'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_090]['item'] );
		}

		if (isset( $this->data['child'][SIMPLEPIE_NAMESPACE_RSS_20]['rss'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_20]['item'])) {
			$this->remove_banned_items( $this->data['child'][SIMPLEPIE_NAMESPACE_RSS_20]['rss'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_20]['item'] );
		}

		if (isset( $this->data['child'][SIMPLEPIE_NAMESPACE_RSS_20]['rss'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_10]['channel'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_20]['item'])) {
			$this->remove_banned_items( $this->data['child'][SIMPLEPIE_NAMESPACE_RSS_20]['rss'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_10]['channel'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_20]['item'] );
		}

		if (isset( $this->data['child'][SIMPLEPIE_NAMESPACE_RSS_20]['rss'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_090]['channel'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_20]['item'])) {
			$this->remove_banned_items( $this->data['child'][SIMPLEPIE_NAMESPACE_RSS_20]['rss'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_090]['channel'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_20]['item'] );
		}

		if (isset( $this->data['child'][SIMPLEPIE_NAMESPACE_RSS_20]['rss'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_20]['channel'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_20]['item'])) {
			$this->remove_banned_items( $this->data['child'][SIMPLEPIE_NAMESPACE_RSS_20]['rss'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_20]['channel'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_20]['item'] );
		}
	}

	public function get_data()
	{
		$this->filter_data();
		return $this->data;
	}
}
