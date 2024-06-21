<?php

namespace GsapDev;

class DatabaseHandler {
    const TABLE_NAME = 'your_custom_table';

    private $table_name;
    private $charset_collate;
    private $db_version = '1.0';

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . self::TABLE_NAME;
        $this->charset_collate = $wpdb->get_charset_collate();

        register_activation_hook(__FILE__, array($this, 'check_and_create_table'));
    }

    public function check_and_create_table() {
        global $wpdb;

        try {
            if ($wpdb->get_var("SHOW TABLES LIKE '{$this->table_name}'") != $this->table_name) {
                $sql = "CREATE TABLE {$this->table_name} (
                    id mediumint(9) NOT NULL AUTO_INCREMENT,
                    name varchar(255) NOT NULL,
                    value text NOT NULL,
                    PRIMARY KEY  (id)
                ) {$this->charset_collate};";

                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                dbDelta($sql);

                add_option('your_custom_table_db_version', $this->db_version);

                add_action('admin_notices', array($this, 'db_creation_success_notice'));
            }
        } catch (\Exception $e) {
            add_action('admin_notices', function() use ($e) {
                ?>
                <div class="notice notice-error is-dismissible">
                    <p><?php _e('Error creating database table: ' . $e->getMessage(), 'basic-wp-plugin'); ?></p>
                </div>
                <?php
            });
        }
    }

    public function db_creation_success_notice() {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e('Database table created successfully.', 'basic-wp-plugin'); ?></p>
        </div>
        <?php
    }

    public function insert_data($name, $value) {
        global $wpdb;
        $wpdb->insert(
            $this->table_name,
            array(
                'name' => $name,
                'value' => $value,
            ),
            array(
                '%s',
                '%s',
            )
        );
    }

    public function get_data($id) {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM {$this->table_name} WHERE id = %d", $id));
    }
}