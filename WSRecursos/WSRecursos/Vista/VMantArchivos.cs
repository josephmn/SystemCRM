using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantArchivos : BDconexion
    {
        public List<EMantenimiento> MantArchivos(Int32 post,
            Int32 id,
            String nombre,
            String mime,
            String type,
            String icono,
            String color,
            String dni)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantArchivos oVMantArchivos = new CMantArchivos();
                    lCEMantenimiento = oVMantArchivos.MantArchivos(con, post, id, nombre, mime, type, icono, color, dni);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}