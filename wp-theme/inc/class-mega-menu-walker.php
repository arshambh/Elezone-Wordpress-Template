<?php
/**
 * Navigation menu walkers.
 *
 * - Arsham_Mega_Menu_Walker: preserves the .second > .inner > ul markup for
 *   the desktop mega menu.
 * - Arsham_Footer_Menu_Walker: prepends an angle icon to each footer link.
 *
 * @package ArshamDecor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Mega-menu walker for the primary header menu.
 */
class Arsham_Mega_Menu_Walker extends Walker_Nav_Menu {

	/**
	 * Open a sub-menu level.
	 *
	 * @param string   $output Output HTML.
	 * @param int      $depth  Current depth.
	 * @param stdClass $args   Menu args.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$indent = str_repeat( "\t", $depth );
		if ( 0 === $depth ) {
			$output .= "\n{$indent}<div class=\"second\"><div class=\"inner\"><ul class=\"sub-menu\">\n";
		} else {
			$output .= "\n{$indent}<ul class=\"sub-menu\">\n";
		}
	}

	/**
	 * Close a sub-menu level.
	 *
	 * @param string   $output Output HTML.
	 * @param int      $depth  Current depth.
	 * @param stdClass $args   Menu args.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$indent = str_repeat( "\t", $depth );
		if ( 0 === $depth ) {
			$output .= "{$indent}</ul></div></div>\n";
		} else {
			$output .= "{$indent}</ul>\n";
		}
	}

	/**
	 * Render a single menu item.
	 *
	 * @param string   $output Output HTML.
	 * @param WP_Post  $item   Menu item.
	 * @param int      $depth  Current depth.
	 * @param stdClass $args   Menu args.
	 * @param int      $id     Item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$indent  = $depth ? str_repeat( "\t", $depth ) : '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$has_children = in_array( 'menu-item-has-children', $classes, true );

		if ( 0 === $depth && $has_children ) {
			$classes[] = 'has_sub';
		}
		if ( 1 === $depth && $has_children ) {
			$classes[] = 'sub';
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= $indent . '<li' . $class_names . '>';

		$atts = array(
			'title'  => ! empty( $item->attr_title ) ? $item->attr_title : '',
			'target' => ! empty( $item->target ) ? $item->target : '',
			'rel'    => ! empty( $item->xfn ) ? $item->xfn : '',
			'href'   => ! empty( $item->url ) ? $item->url : '',
		);
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$attributes .= ' ' . $attr . '="' . esc_attr( $value ) . '"';
			}
		}

		$title = apply_filters( 'the_title', $item->title, $item->ID );

		$arrow = '';
		if ( 1 === $depth && $has_children ) {
			$arrow = '<i class="q_menu_arrow fal fa-angle-left"></i>';
		}

		$item_output  = isset( $args->before ) ? $args->before : '';
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $arrow;
		$item_output .= ( isset( $args->link_before ) ? $args->link_before : '' ) . $title . ( isset( $args->link_after ) ? $args->link_after : '' );
		$item_output .= '</a>';
		$item_output .= isset( $args->after ) ? $args->after : '';

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

/**
 * Footer menu walker: prepends an angle icon to each link.
 */
class Arsham_Footer_Menu_Walker extends Walker_Nav_Menu {

	/**
	 * Render a single footer item.
	 *
	 * @param string   $output Output HTML.
	 * @param WP_Post  $item   Menu item.
	 * @param int      $depth  Current depth.
	 * @param stdClass $args   Menu args.
	 * @param int      $id     Item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes     = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$atts = array(
			'target' => ! empty( $item->target ) ? $item->target : '',
			'rel'    => ! empty( $item->xfn ) ? $item->xfn : '',
			'href'   => ! empty( $item->url ) ? $item->url : '',
		);
		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$attributes .= ' ' . $attr . '="' . esc_attr( $value ) . '"';
			}
		}

		$title = apply_filters( 'the_title', $item->title, $item->ID );

		$output .= '<li' . $class_names . '>';
		$output .= '<a' . $attributes . '><i class="fal fa-angle-left ml-2"></i>' . esc_html( $title ) . '</a>';
	}
}
