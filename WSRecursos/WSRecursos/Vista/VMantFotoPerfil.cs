using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantFotoPerfil : BDconexion
    {
        public List<EMantenimiento> MantFotoPerfil(String dni, String nombre, String ruta)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantFotoPerfil oVMantFotoPerfil = new CMantFotoPerfil();
                    lCEMantenimiento = oVMantFotoPerfil.MantFotoPerfil(con, dni, nombre, ruta);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}