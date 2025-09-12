<?php
/**
 * Módulo de Carga JSON - FastControl
 * Carga datos desde archivos JSON y los convierte al formato esperado por la aplicación
 */

class DataLoader {
    private static $data_path = __DIR__ . '/../data/';
    private static $cache = [];

    /**
     * Carga datos de un archivo JSON
     */
    public static function load($filename) {
        // Verificar si ya está en caché
        if (isset(self::$cache[$filename])) {
            return self::$cache[$filename];
        }

        $file_path = self::$data_path . $filename . '.json';
        
        if (!file_exists($file_path)) {
            return null;
        }
        
        $json_content = file_get_contents($file_path);
        $data = json_decode($json_content, true);
        
        // Guardar en caché
        self::$cache[$filename] = $data;
        
        return $data;
    }

    /**
     * Guarda datos en un archivo JSON
     */
    public static function save($filename, $data) {
        $file_path = self::$data_path . $filename . '.json';
        $json_content = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        
        if (file_put_contents($file_path, $json_content)) {
            // Actualizar caché
            self::$cache[$filename] = $data;
            return true;
        }
        
        return false;
    }

    /**
     * Obtiene datos de empresa
     */
    public static function getEmpresa() {
        return self::load('empresa');
    }

    /**
     * Obtiene datos de servicios
     */
    public static function getServicios() {
        return self::load('servicios');
    }

    /**
     * Obtiene datos de links
     */
    public static function getLinks() {
        return self::load('links');
    }

    /**
     * Obtiene un servicio por su ID
     * 
     * @param int $id ID del servicio
     * @return array|null Datos del servicio o null si no se encuentra
     */
    public static function getServicioById($id) {
        $servicios = self::getServicios();
        
        foreach ($servicios as $servicio) {
            if ($servicio['id'] == $id) {
                return $servicio;
            }
        }
        
        return null;
    }

    /**
     * Actualiza un servicio
     * 
     * @param int $id ID del servicio
     * @param array $data Datos del servicio
     * @return bool Éxito de la operación
     */
    public static function updateServicio($id, $data) {
        $servicios = self::getServicios();
        $updated = false;
        
        foreach ($servicios as $key => $servicio) {
            if ($servicio['id'] == $id) {
                $servicios[$key] = $data;
                $updated = true;
                break;
            }
        }
        
        if ($updated) {
            return self::save('servicios', $servicios);
        }
        
        return false;
    }

    /**
     * Añade un nuevo servicio
     * 
     * @param array $data Datos del servicio
     * @return bool Éxito de la operación
     */
    public static function addServicio($data) {
        $servicios = self::getServicios();
        
        // Generar nuevo ID
        $maxId = 0;
        foreach ($servicios as $servicio) {
            if ($servicio['id'] > $maxId) {
                $maxId = $servicio['id'];
            }
        }
        
        $data['id'] = $maxId + 1;
        $servicios[] = $data;
        
        return self::save('servicios', $servicios);
    }

    /**
     * Elimina un servicio
     * 
     * @param int $id ID del servicio
     * @return bool Éxito de la operación
     */
    public static function deleteServicio($id) {
        $servicios = self::getServicios();
        $newServicios = [];
        
        foreach ($servicios as $servicio) {
            if ($servicio['id'] != $id) {
                $newServicios[] = $servicio;
            }
        }
        
        return self::save('servicios', $newServicios);
    }
}

// Función helper para obtener datos de empresa
function empresa() {
    return DataLoader::getEmpresa();
}

// Función helper para obtener datos de servicios
function servicios() {
    return DataLoader::getServicios();
}

// Función helper para obtener datos de links
function links() {
    return DataLoader::getLinks();
}
