<?php

namespace App\Database\Seeds;

class basedata extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'repitalisasi_pembagi', 'value' => 'sqrt(10)'],
            ['name' => 'repitalisasi_df', 'value' => '9'],
            ['name' => 'repitalisasi_ci', 'value' => '1'],
            ['name' => 'gas_std_pembagi', 'value' => 'sqrt(3)'],
            ['name' => 'gas_std_df', 'value' => '100000000000000000000'],
            ['name' => 'gas_std_ci', 'value' => '1'],
            ['name' => 'flowmeter_pembagi', 'value' => '2'],
            ['name' => 'flowmeter_df', 'value' => '100000000000000000000'],
            ['name' => 'flowmeter_ci', 'value' => '0'],
            ['name' => 'resolusi_pembagi', 'value' => 'sqrt(3)'],
            ['name' => 'resolusi_df', 'value' => '100000000000000000000'],
            ['name' => 'resolusi_ci', 'value' => '1'],
            ['name' => 'flow_u95', 'value' => '0.191'],
        ];
        $this->db->table('constant_values')->insertBatch($data);

        $data = [
            ['name' => 'Thermo-01', 'brand' => 'HTC', 'type' => 'HTC-1', 'serial_no' => '20.01251A', 'calibrated_at' => '2020-02-21', 'telusuran' => 'Balai Kalibrasi Kemendag', 'temp_unc' => '0.23', 'rh_unc' => '0.71'],
            ['name' => 'Thermo-02', 'brand' => 'HTC', 'type' => 'HTC-1', 'serial_no' => '20.01252A', 'calibrated_at' => '2020-02-21', 'telusuran' => 'Balai Kalibrasi Kemendag', 'temp_unc' => '0.23', 'rh_unc' => '0.71'],
            ['name' => 'Thermo-03', 'brand' => 'HTC', 'type' => 'HTC-1', 'serial_no' => '20.01253A', 'calibrated_at' => '2020-02-21', 'telusuran' => 'Balai Kalibrasi Kemendag', 'temp_unc' => '0.23', 'rh_unc' => '0.71'],
            ['name' => 'Thermo-04', 'brand' => 'HTC', 'type' => 'HTC-1', 'serial_no' => '20.01254A', 'calibrated_at' => '2020-02-21', 'telusuran' => 'Balai Kalibrasi Kemendag', 'temp_unc' => '0.23', 'rh_unc' => '0.71'],
        ];
        $this->db->table('thermohygrometers')->insertBatch($data);

        $data = [
            ['thermohygrometer_id' => '1', 'temp' => '15', 'temp_correction' => '0.31', 'rh' => '30.0', 'rh_correction' => '2.3'],
            ['thermohygrometer_id' => '1', 'temp' => '19.9', 'temp_correction' => '0.31', 'rh' => '49.0', 'rh_correction' => '2.3'],
            ['thermohygrometer_id' => '1', 'temp' => '24.2', 'temp_correction' => '0.75', 'rh' => '55.0', 'rh_correction' => '1.2'],
            ['thermohygrometer_id' => '1', 'temp' => '28.3', 'temp_correction' => '1.35', 'rh' => '61.0', 'rh_correction' => '0.3'],
            ['thermohygrometer_id' => '1', 'temp' => '0', 'temp_correction' => '0', 'rh' => '90', 'rh_correction' => '-0.9'],
            ['thermohygrometer_id' => '2', 'temp' => '15', 'temp_correction' => '-0.1', 'rh' => '30.0', 'rh_correction' => '0.3'],
            ['thermohygrometer_id' => '2', 'temp' => '20.3', 'temp_correction' => '-0.09', 'rh' => '51.0', 'rh_correction' => '0.3'],
            ['thermohygrometer_id' => '2', 'temp' => '24.5', 'temp_correction' => '0.45', 'rh' => '58.0', 'rh_correction' => '-1.8'],
            ['thermohygrometer_id' => '2', 'temp' => '28.7', 'temp_correction' => '0.95', 'rh' => '63.0', 'rh_correction' => '-1.7'],
            ['thermohygrometer_id' => '2', 'temp' => '0', 'temp_correction' => '0', 'rh' => '90', 'rh_correction' => '-3.3'],
            ['thermohygrometer_id' => '3', 'temp' => '15', 'temp_correction' => '-0.49', 'rh' => '30.0', 'rh_correction' => '3.3'],
            ['thermohygrometer_id' => '3', 'temp' => '20.7', 'temp_correction' => '-0.49', 'rh' => '48.0', 'rh_correction' => '3.3'],
            ['thermohygrometer_id' => '3', 'temp' => '25.0', 'temp_correction' => '-0.05', 'rh' => '54.0', 'rh_correction' => '2.2'],
            ['thermohygrometer_id' => '3', 'temp' => '29.2', 'temp_correction' => '0.45', 'rh' => '61.0', 'rh_correction' => '0.3'],
            ['thermohygrometer_id' => '3', 'temp' => '0', 'temp_correction' => '0', 'rh' => '90', 'rh_correction' => '0.3'],
            ['thermohygrometer_id' => '4', 'temp' => '15', 'temp_correction' => '-0.09', 'rh' => '30.0', 'rh_correction' => '0.3'],
            ['thermohygrometer_id' => '4', 'temp' => '20.3', 'temp_correction' => '-0.09', 'rh' => '51.0', 'rh_correction' => '0.3'],
            ['thermohygrometer_id' => '4', 'temp' => '24.5', 'temp_correction' => '0.45', 'rh' => '58.0', 'rh_correction' => '-1.8'],
            ['thermohygrometer_id' => '4', 'temp' => '28.7', 'temp_correction' => '0.95', 'rh' => '63.0', 'rh_correction' => '-1.7'],
            ['thermohygrometer_id' => '4', 'temp' => '0', 'temp_correction' => '0', 'rh' => '90', 'rh_correction' => '-1.7'],
        ];
        $this->db->table('thermohygrometer_details')->insertBatch($data);

        $data = [
            ['name' => 'Analyzer'],
            ['name' => 'Automotive'],
            ['name' => 'Detector'],
            ['name' => 'CEM'],
            ['name' => 'FGM/AQM'],
            ['name' => 'Gas Ambient'],
        ];
        $this->db->table('instrument_types')->insertBatch($data);
    }
}
