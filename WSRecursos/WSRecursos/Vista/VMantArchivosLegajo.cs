using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantArchivosLegajo : BDconexion
    {
        public List<EMantenimiento> MantArchivosLegajo(
            Int32 post,
            Int32 id,
            String nombre,
            String carpeta,
            String modulo,
            Int32 estado,
            Int32 cantidad,
            String tipoarchivo,
            String tamanio,
            String dni)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantArchivosLegajo oVMantArchivosLegajo = new CMantArchivosLegajo();
                    lCEMantenimiento = oVMantArchivosLegajo.MantArchivosLegajo(con, post, id, nombre, carpeta, modulo, estado, cantidad, tipoarchivo, tamanio, dni);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}