using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CProvincia
    {
        public List<EProvincia> Listar_Provincia(SqlConnection con, Int32 departamento)
        {
            List<EProvincia> lEProvincia = null;
            SqlCommand cmd = new SqlCommand("ASP_PROVINCIA", con);
            cmd.CommandType = CommandType.StoredProcedure;

            SqlParameter par1 = cmd.Parameters.Add("@departamento", SqlDbType.Int);
            par1.Direction = ParameterDirection.Input;
            par1.Value = departamento;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEProvincia = new List<EProvincia>();

                EProvincia obEProvincia = null;
                while (drd.Read())
                {
                    obEProvincia = new EProvincia();
                    obEProvincia.i_idpro = drd["i_idpro"].ToString();
                    obEProvincia.v_descripcion = drd["v_descripcion"].ToString();
                    lEProvincia.Add(obEProvincia);
                }
                drd.Close();
            }

            return (lEProvincia);
        }
    }
}