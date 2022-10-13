using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantCronograma : BDconexion
    {
        public List<EMantenimiento> MantCronograma(Int32 post, Int32 codigo, String dni, Int32 mes, Int32 tipo, Int32 dias, Int32 anhio, String user)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantCronograma oVMantCronograma = new CMantCronograma();
                    lCEMantenimiento = oVMantCronograma.MantCronograma(con, post, codigo, dni, mes, tipo, dias, anhio, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}