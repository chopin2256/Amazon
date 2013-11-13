<?php

interface I_Amazon {

    /**
     * Set your configuration options here
     * 
     */
    public function config();

    /**
     * Set your Amazon keword here
     * @param string $kw Keyword
     * @return array Amazon product information
     */
    public function search($kw);

    /**
     * Get Amazon attributes here
     */
    public function get();

    /**
     * Clears cache, must run if running in a loop
     * Optional only if there is no iteration or data dumps taking place
     */
    public function clear();
}
