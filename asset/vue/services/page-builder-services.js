/**
 * Part of earth project.
 *
 * @copyright  Copyright (C) 2020 .
 * @license    __LICENSE__
 */

export default class PageBuilderService {
  static rowData(data = {}) {
    return {
      id: 'row-' + Phoenix.uniqid(),
      options: {
        label: '',
        title: {
          text: '',
          element: 'h3',
          font_size: {
            lg: '',
            md: '',
            xs: ''
          },
          font_weight: '',
          color: '',
          margin_top: {
            lg: '',
            md: '',
            xs: ''
          },
          margin_bottom: {
            lg: '',
            md: '',
            xs: ''
          }
        },
        subtitle: {
          text: '',
          font_size: {
            lg: '',
            md: '',
            xs: ''
          }
        },
        html_id: '',
        html_class: '',
        title_align: 'center',
        valign: 'top',
        fluid_row: false,
        no_gutter: false,
        padding: {
          xl: '',
          md: '',
          xs: ''
        },
        margin: {
          xl: '',
          md: '',
          xs: ''
        },
        display: {
          xs: 'd-block',
          md: 'd-md-block',
          lg: 'd-lg-block'
        },
        text_color: '',
        background: {
          type: 'none',
          color: '',
          image: {
            url: '',
            overlay: '',
            repeat: '',
            position: 'center center',
            attachment: 'inherit',
            size: 'cover'
          },
          gradient: {
            type: 'liner',
            angle: '',
            start_color: '',
            start_pos: '',
            end_color: '',
            end_pos: ''
          },
          video: {
            url: '',
            overlay: ''
          },
          parallax: false
        },
        animation: {
          name: '',
          duration: 300,
          delay: 0
        }
      },
      columns: [],
    };
  }
}
