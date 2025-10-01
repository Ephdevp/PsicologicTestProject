<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Drop old function (if exists) and recreate with explicit utf8mb4_unicode_ci collations
        DB::unprepared(<<<'SQL'
DROP FUNCTION IF EXISTS lookup_sten;
CREATE FUNCTION lookup_sten(
    p_sex VARCHAR(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    p_age INT,
    p_factor VARCHAR(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    p_raw INT
) RETURNS TINYINT
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE v_sten TINYINT;

    /* Ensure string comparisons use utf8mb4_unicode_ci to avoid collation mismatches */
    CASE UPPER(p_factor)
        WHEN 'A'  THEN SELECT sten_value INTO v_sten FROM sten_age_s WHERE (sex COLLATE utf8mb4_unicode_ci) = (p_sex COLLATE utf8mb4_unicode_ci) AND p_age BETWEEN age_from AND age_to AND p_raw BETWEEN A_from AND A_to LIMIT 1;
        WHEN 'B'  THEN SELECT sten_value INTO v_sten FROM sten_age_s WHERE (sex COLLATE utf8mb4_unicode_ci) = (p_sex COLLATE utf8mb4_unicode_ci) AND p_age BETWEEN age_from AND age_to AND p_raw BETWEEN B_from AND B_to LIMIT 1;
        WHEN 'C'  THEN SELECT sten_value INTO v_sten FROM sten_age_s WHERE (sex COLLATE utf8mb4_unicode_ci) = (p_sex COLLATE utf8mb4_unicode_ci) AND p_age BETWEEN age_from AND age_to AND p_raw BETWEEN C_from AND C_to LIMIT 1;
        WHEN 'E'  THEN SELECT sten_value INTO v_sten FROM sten_age_s WHERE (sex COLLATE utf8mb4_unicode_ci) = (p_sex COLLATE utf8mb4_unicode_ci) AND p_age BETWEEN age_from AND age_to AND p_raw BETWEEN E_from AND E_to LIMIT 1;
        WHEN 'F'  THEN SELECT sten_value INTO v_sten FROM sten_age_s WHERE (sex COLLATE utf8mb4_unicode_ci) = (p_sex COLLATE utf8mb4_unicode_ci) AND p_age BETWEEN age_from AND age_to AND p_raw BETWEEN F_from AND F_to LIMIT 1;
        WHEN 'G'  THEN SELECT sten_value INTO v_sten FROM sten_age_s WHERE (sex COLLATE utf8mb4_unicode_ci) = (p_sex COLLATE utf8mb4_unicode_ci) AND p_age BETWEEN age_from AND age_to AND p_raw BETWEEN G_from AND G_to LIMIT 1;
        WHEN 'H'  THEN SELECT sten_value INTO v_sten FROM sten_age_s WHERE (sex COLLATE utf8mb4_unicode_ci) = (p_sex COLLATE utf8mb4_unicode_ci) AND p_age BETWEEN age_from AND age_to AND p_raw BETWEEN H_from AND H_to LIMIT 1;
        WHEN 'I'  THEN SELECT sten_value INTO v_sten FROM sten_age_s WHERE (sex COLLATE utf8mb4_unicode_ci) = (p_sex COLLATE utf8mb4_unicode_ci) AND p_age BETWEEN age_from AND age_to AND p_raw BETWEEN I_from AND I_to LIMIT 1;
        WHEN 'L'  THEN SELECT sten_value INTO v_sten FROM sten_age_s WHERE (sex COLLATE utf8mb4_unicode_ci) = (p_sex COLLATE utf8mb4_unicode_ci) AND p_age BETWEEN age_from AND age_to AND p_raw BETWEEN L_from AND L_to LIMIT 1;
        WHEN 'M'  THEN SELECT sten_value INTO v_sten FROM sten_age_s WHERE (sex COLLATE utf8mb4_unicode_ci) = (p_sex COLLATE utf8mb4_unicode_ci) AND p_age BETWEEN age_from AND age_to AND p_raw BETWEEN M_from AND M_to LIMIT 1;
        WHEN 'N'  THEN SELECT sten_value INTO v_sten FROM sten_age_s WHERE (sex COLLATE utf8mb4_unicode_ci) = (p_sex COLLATE utf8mb4_unicode_ci) AND p_age BETWEEN age_from AND age_to AND p_raw BETWEEN N_from AND N_to LIMIT 1;
        WHEN 'O'  THEN SELECT sten_value INTO v_sten FROM sten_age_s WHERE (sex COLLATE utf8mb4_unicode_ci) = (p_sex COLLATE utf8mb4_unicode_ci) AND p_age BETWEEN age_from AND age_to AND p_raw BETWEEN O_from AND O_to LIMIT 1;
        WHEN 'Q1' THEN SELECT sten_value INTO v_sten FROM sten_age_s WHERE (sex COLLATE utf8mb4_unicode_ci) = (p_sex COLLATE utf8mb4_unicode_ci) AND p_age BETWEEN age_from AND age_to AND p_raw BETWEEN Q1_from AND Q1_to LIMIT 1;
        WHEN 'Q2' THEN SELECT sten_value INTO v_sten FROM sten_age_s WHERE (sex COLLATE utf8mb4_unicode_ci) = (p_sex COLLATE utf8mb4_unicode_ci) AND p_age BETWEEN age_from AND age_to AND p_raw BETWEEN Q2_from AND Q2_to LIMIT 1;
        WHEN 'Q3' THEN SELECT sten_value INTO v_sten FROM sten_age_s WHERE (sex COLLATE utf8mb4_unicode_ci) = (p_sex COLLATE utf8mb4_unicode_ci) AND p_age BETWEEN age_from AND age_to AND p_raw BETWEEN Q3_from AND Q3_to LIMIT 1;
        WHEN 'Q4' THEN SELECT sten_value INTO v_sten FROM sten_age_s WHERE (sex COLLATE utf8mb4_unicode_ci) = (p_sex COLLATE utf8mb4_unicode_ci) AND p_age BETWEEN age_from AND age_to AND p_raw BETWEEN Q4_from AND Q4_to LIMIT 1;
        ELSE
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT='Unknown factor code';
    END CASE;

    RETURN v_sten;
END
SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP FUNCTION IF EXISTS lookup_sten;');
    }
};
