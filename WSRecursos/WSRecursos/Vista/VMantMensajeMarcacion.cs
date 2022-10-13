using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantMensajeMarcacion : BDconexion
    {
        public List<EMantenimiento> MantMensajeMarcacion(String dni)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantMensajeMarcacion oVMantMensajeMarcacion = new CMantMensajeMarcacion();
                    lCEMantenimiento = oVMantMensajeMarcacion.MantMensajeMarcacion(con, dni);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}