using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantVacaciones : BDconexion
    {
        public List<EMantenimiento> MantVacaciones(String id, Int32 codigo, String dni, String indice)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantVacaciones oVMantVacaciones = new CMantVacaciones();
                    lCEMantenimiento = oVMantVacaciones.MantVacaciones(con, id, codigo, dni, indice);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}