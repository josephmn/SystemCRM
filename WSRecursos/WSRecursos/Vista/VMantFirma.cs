using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantFirma : BDconexion
    {
        public List<EMantenimiento> MantFirma(String dni, String nombre, String ruta)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantFirma oVMantFirma = new CMantFirma();
                    lCEMantenimiento = oVMantFirma.MantFirma(con, dni, nombre, ruta);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}