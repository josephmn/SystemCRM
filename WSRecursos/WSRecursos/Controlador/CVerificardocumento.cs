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
    public class CVerificardocumento
    {
        public List<EVerificardocumento> Listar_Verificardocumento(SqlConnection con, String dni)
        {
            List<EVerificardocumento> lEVerificardocumento = null;
            SqlCommand cmd = new SqlCommand("ASP_VALIDAR_DOCUMENTO", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEVerificardocumento = new List<EVerificardocumento>();

                EVerificardocumento obEVerificardocumento = null;
                while (drd.Read())
                {
                    obEVerificardocumento = new EVerificardocumento();
                    obEVerificardocumento.v_dni = drd["v_dni"].ToString();
                    obEVerificardocumento.v_nombre = drd["v_nombre"].ToString();
                    lEVerificardocumento.Add(obEVerificardocumento);
                }
                drd.Close();
            }

            return (lEVerificardocumento);
        }
    }
}